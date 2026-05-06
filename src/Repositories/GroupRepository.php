<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Mappers\GroupMapper;
use App\Mappers\StandingMapper;
use Framework\Database\GroupRepositoryInterface;
use Framework\Database\DatabaseInterface;

class GroupRepository implements GroupRepositoryInterface
{
    private DatabaseInterface $database;
    private GroupMapper       $groupMapper;
    private StandingMapper    $standingMapper;

    public function __construct(
        DatabaseInterface $database,
        GroupMapper       $groupMapper,
        StandingMapper    $standingMapper
    ) {
        $this->database       = $database;
        $this->groupMapper    = $groupMapper;
        $this->standingMapper = $standingMapper;
    }

    public function findByCup(int $idCup): array
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare("
            SELECT id_groupe, nom, id_cup
            FROM   groupe
            WHERE  id_cup = ?
            ORDER  BY nom
        ");
        $stmt->execute([$idCup]);

        return $this->groupMapper->mapToList($stmt->fetchAll());
    }

    public function getStandings(int $idGroupe): array
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare("
            SELECT e.id_user, u.username,
                   e.played, e.wins, e.draws, e.losses,
                   e.goals_for, e.goals_against, e.points
            FROM   est_classe_dans e
            JOIN   users           u ON e.id_user = u.id_user
            WHERE  e.id_groupe = ?
            ORDER  BY e.points DESC,
                      (e.goals_for - e.goals_against) DESC,
                      e.goals_for DESC
        ");
        $stmt->execute([$idGroupe]);

        return $this->standingMapper->mapToList($stmt->fetchAll());
    }
}
