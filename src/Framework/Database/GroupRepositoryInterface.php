<?php

declare(strict_types=1);

namespace Framework\Database;

use App\Entities\Group;
use App\Entities\Standing;

// Contrat pour toutes les opérations de données sur les groupes.
interface GroupRepositoryInterface extends RepositoryInterface
{
    // Retourne tous les groupes d'une cup.
    public function findByCup(int $idCup): array;

    // Retourne le classement d'un groupe trié par points.
    public function getStandings(int $idGroupe): array;
}
