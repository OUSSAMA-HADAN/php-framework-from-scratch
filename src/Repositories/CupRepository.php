<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Cup;
use App\Mappers\CupMapper;
use Framework\Database\CupRepositoryInterface;
use Framework\Database\DatabaseInterface;

class CupRepository implements CupRepositoryInterface
{
    private DatabaseInterface $database;
    private CupMapper         $mapper;

    public function __construct(DatabaseInterface $database, CupMapper $mapper)
    {
        $this->database = $database;
        $this->mapper   = $mapper;
    }

    public function findAll(): array
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->query("
            SELECT c.id_cup, c.titre, c.statut, c.visibilite,
                   c.min_players, c.max_players, c.qualification,
                   u.username AS organisateur
            FROM   cup   c
            JOIN   users u ON c.created_by = u.id_user
            ORDER  BY c.created_at DESC
        ");

        return $this->mapper->mapToList($stmt->fetchAll());
    }

    public function findById(int $id): ?Cup
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare("
            SELECT c.id_cup, c.titre, c.statut, c.visibilite,
                   c.min_players, c.max_players, c.qualification,
                   u.username AS organisateur
            FROM   cup   c
            JOIN   users u ON c.created_by = u.id_user
            WHERE  c.id_cup = ?
        ");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row !== false ? $this->mapper->mapToObject($row) : null;
    }

    public function findOpenCups(): array
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->query("
            SELECT c.id_cup, c.titre, c.statut, c.visibilite,
                   c.min_players, c.max_players, c.qualification,
                   u.username AS organisateur
            FROM   cup   c
            JOIN   users u ON c.created_by = u.id_user
            WHERE  c.visibilite = 'public'
              AND  c.statut     IN ('open', 'started')
            ORDER  BY c.created_at DESC
        ");

        return $this->mapper->mapToList($stmt->fetchAll());
    }

    public function create(
        string  $titre,
        string  $visibilite,
        ?string $joinCode,
        int     $minPlayers,
        int     $maxPlayers,
        int     $createdBy
    ): Cup {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO cup (titre, visibilite, join_code, min_players, max_players, statut, created_by)
            VALUES (?, ?, ?, ?, ?, 'open', ?)
        ");
        $stmt->execute([$titre, $visibilite, $joinCode, $minPlayers, $maxPlayers, $createdBy]);

        return $this->findById((int) $pdo->lastInsertId());
    }

    public function updateStatut(int $id, string $statut): void
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare("UPDATE cup SET statut = ? WHERE id_cup = ?");
        $stmt->execute([$statut, $id]);
    }

    public function isParticipant(int $idCup, int $idUser): bool
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare("
            SELECT 1 FROM participe WHERE id_cup = ? AND id_user = ? LIMIT 1
        ");
        $stmt->execute([$idCup, $idUser]);

        return $stmt->fetchColumn() !== false;
    }

    public function join(int $idCup, int $idUser): void
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare("
            INSERT IGNORE INTO participe (id_cup, id_user, role) VALUES (?, ?, 'player')
        ");
        $stmt->execute([$idCup, $idUser]);
    }

    public function getParticipants(int $idCup): array
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare("
            SELECT u.username, p.role, p.date_adhesion
            FROM   participe p
            JOIN   users     u ON u.id_user = p.id_user
            WHERE  p.id_cup = ?
            ORDER  BY p.role DESC, p.date_adhesion ASC
        ");
        $stmt->execute([$idCup]);
        return $stmt->fetchAll();
    }
}
