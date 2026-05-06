<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Matche;
use App\Mappers\MatcheMapper;
use Framework\Database\MatcheRepositoryInterface;
use Framework\Database\DatabaseInterface;

class MatcheRepository implements MatcheRepositoryInterface
{
    private DatabaseInterface $database;
    private MatcheMapper      $mapper;

    public function __construct(DatabaseInterface $database, MatcheMapper $mapper)
    {
        $this->database = $database;
        $this->mapper   = $mapper;
    }

    // Requête de base réutilisée partout — jointures complètes
    private function baseQuery(): string
    {
        return "
            SELECT m.id_match, m.round, m.leg, m.statut,
                   h.username  AS home_name,  a.username  AS away_name,
                   m.home_user_id,             m.away_user_id,
                   c.titre     AS cup_titre,
                   r.home_score AS result_home, r.away_score AS result_away
            FROM      matche   m
            JOIN      users    h ON m.home_user_id = h.id_user
            JOIN      users    a ON m.away_user_id = a.id_user
            JOIN      cup      c ON m.id_cup       = c.id_cup
            LEFT JOIN resultat r ON r.id_match     = m.id_match
        ";
    }

    public function findByUser(int $idUser): array
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare(
            $this->baseQuery() . "
            WHERE (m.home_user_id = ? OR m.away_user_id = ?)
            ORDER BY FIELD(m.statut, 'pending','submitted','disputed','confirmed','forfeited'),
                     m.created_at DESC
            "
        );
        $stmt->execute([$idUser, $idUser]);

        return $this->mapper->mapToList($stmt->fetchAll());
    }

    public function findKnockoutByCup(int $idCup): array
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare(
            $this->baseQuery() . "
            WHERE m.round != 'group' AND m.id_cup = ?
            ORDER BY FIELD(m.round,'R16','QF','SF','F'), m.leg, m.id_match
            "
        );
        $stmt->execute([$idCup]);
        $matches = $this->mapper->mapToList($stmt->fetchAll());

        // Grouper par round
        $byRound = [];
        foreach ($matches as $m) {
            $byRound[$m->getRound()][] = $m;
        }
        return $byRound;
    }

    public function findByGroup(int $idGroupe): array
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare(
            $this->baseQuery() . "
            WHERE m.id_groupe = ?
            ORDER BY m.leg, m.id_match
            "
        );
        $stmt->execute([$idGroupe]);

        return $this->mapper->mapToList($stmt->fetchAll());
    }

    public function findDisputed(): array
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->query(
            $this->baseQuery() . "
            WHERE m.statut = 'disputed'
            ORDER BY m.created_at ASC
            "
        );

        return $this->mapper->mapToList($stmt->fetchAll());
    }

    public function create(
        string $round,
        string $leg,
        int    $idCup,
        ?int   $idGroupe,
        int    $homeUserId,
        int    $awayUserId
    ): Matche {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO matche (round, leg, id_cup, id_groupe, home_user_id, away_user_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$round, $leg, $idCup, $idGroupe, $homeUserId, $awayUserId]);

        $id   = (int) $pdo->lastInsertId();
        $stmt = $pdo->prepare($this->baseQuery() . " WHERE m.id_match = ?");
        $stmt->execute([$id]);

        return $this->mapper->mapToObject($stmt->fetch());
    }

    public function submitScore(int $idMatch, int $idUser, int $homeScore, int $awayScore): string
    {
        $pdo = $this->database->getConnection();

        // Insérer ou mettre à jour la soumission du joueur
        $stmt = $pdo->prepare("
            INSERT INTO submission (home_score, away_score, id_match, id_user)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE home_score = VALUES(home_score),
                                    away_score = VALUES(away_score)
        ");
        $stmt->execute([$homeScore, $awayScore, $idMatch, $idUser]);

        // Compter les soumissions pour ce match
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM submission WHERE id_match = ?");
        $stmt->execute([$idMatch]);

        if ($stmt->fetchColumn() < 2) {
            $pdo->prepare("UPDATE matche SET statut='submitted' WHERE id_match=?")->execute([$idMatch]);
            return 'waiting';
        }

        // Les deux joueurs ont soumis — récupérer les deux scores
        $stmt = $pdo->prepare("
            SELECT s.home_score, s.away_score, m.home_user_id, m.away_user_id, m.round, m.id_groupe
            FROM   submission s
            JOIN   matche     m ON m.id_match = s.id_match
            WHERE  s.id_match = ? AND s.id_user = m.home_user_id
        ");
        $stmt->execute([$idMatch]);
        $home = $stmt->fetch();

        $stmt = $pdo->prepare("
            SELECT s.home_score, s.away_score
            FROM   submission s
            JOIN   matche     m ON m.id_match = s.id_match
            WHERE  s.id_match = ? AND s.id_user = m.away_user_id
        ");
        $stmt->execute([$idMatch]);
        $away = $stmt->fetch();

        if ($home['home_score'] === $away['home_score'] && $home['away_score'] === $away['away_score']) {
            // Accord → confirmation automatique
            $pdo->prepare("
                INSERT INTO resultat (home_score, away_score, id_match, confirmed_by)
                VALUES (?, ?, ?, NULL)
            ")->execute([$home['home_score'], $home['away_score'], $idMatch]);

            $pdo->prepare("UPDATE matche SET statut='confirmed' WHERE id_match=?")->execute([$idMatch]);

            // Mise à jour du classement si match de groupe
            if ($home['round'] === 'group' && $home['id_groupe'] !== null) {
                $this->updateStandings(
                    $pdo,
                    (int) $home['home_user_id'],
                    (int) $home['away_user_id'],
                    (int) $home['home_score'],
                    (int) $home['away_score'],
                    (int) $home['id_groupe']
                );
            }

            return 'confirmed';
        }

        // Désaccord → litige
        $pdo->prepare("UPDATE matche SET statut='disputed' WHERE id_match=?")->execute([$idMatch]);

        return 'disputed';
    }

    private function updateStandings(
        \PDO $pdo,
        int  $homeUserId,
        int  $awayUserId,
        int  $homeScore,
        int  $awayScore,
        int  $idGroupe
    ): void {
        $sql = "
            UPDATE est_classe_dans
            SET played        = played + 1,
                wins          = wins   + ?,
                draws         = draws  + ?,
                losses        = losses + ?,
                goals_for     = goals_for     + ?,
                goals_against = goals_against + ?,
                points        = points + ?
            WHERE id_user = ? AND id_groupe = ?
        ";
        $stmt = $pdo->prepare($sql);

        if ($homeScore > $awayScore) {
            // Domicile gagne
            $stmt->execute([1, 0, 0, $homeScore, $awayScore, 3, $homeUserId, $idGroupe]);
            $stmt->execute([0, 0, 1, $awayScore, $homeScore, 0, $awayUserId, $idGroupe]);
        } elseif ($awayScore > $homeScore) {
            // Extérieur gagne
            $stmt->execute([0, 0, 1, $homeScore, $awayScore, 0, $homeUserId, $idGroupe]);
            $stmt->execute([1, 0, 0, $awayScore, $homeScore, 3, $awayUserId, $idGroupe]);
        } else {
            // Match nul
            $stmt->execute([0, 1, 0, $homeScore, $awayScore, 1, $homeUserId, $idGroupe]);
            $stmt->execute([0, 1, 0, $awayScore, $homeScore, 1, $awayUserId, $idGroupe]);
        }
    }
}
