<?php

declare(strict_types=1);

namespace App\Mappers;

use App\Entities\Standing;

// Seul endroit qui connaît les noms des colonnes SQL de est_classe_dans.
class StandingMapper
{
    public function mapToObject(array $row): Standing
    {
        $standing = new Standing();

        $standing->setIdUser((int) $row['id_user']);
        $standing->setUsername((string) $row['username']);
        $standing->setPlayed((int) $row['played']);
        $standing->setWins((int) $row['wins']);
        $standing->setDraws((int) $row['draws']);
        $standing->setLosses((int) $row['losses']);
        $standing->setGoalsFor((int) $row['goals_for']);
        $standing->setGoalsAgainst((int) $row['goals_against']);
        $standing->setPoints((int) $row['points']);

        return $standing;
    }

    /** @return Standing[] */
    public function mapToList(array $rows): array
    {
        return array_map(fn($row) => $this->mapToObject($row), $rows);
    }
}
