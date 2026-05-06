<?php

declare(strict_types=1);

namespace App\Mappers;

use App\Entities\Cup;

// Seul endroit qui connaît les noms des colonnes SQL de cup.
class CupMapper
{
    public function mapToObject(array $row): Cup
    {
        $cup = new Cup();

        $cup->setId((int) $row['id_cup']);
        $cup->setTitre((string) $row['titre']);
        $cup->setStatut((string) $row['statut']);
        $cup->setVisibilite((string) $row['visibilite']);
        $cup->setMinPlayers((int) $row['min_players']);
        $cup->setMaxPlayers((int) $row['max_players']);
        $cup->setQualification((int) $row['qualification']);
        $cup->setOrganisateur((string) $row['organisateur']);

        return $cup;
    }

    /** @return Cup[] */
    public function mapToList(array $rows): array
    {
        return array_map(fn($row) => $this->mapToObject($row), $rows);
    }
}
