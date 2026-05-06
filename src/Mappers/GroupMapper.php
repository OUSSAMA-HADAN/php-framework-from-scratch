<?php

declare(strict_types=1);

namespace App\Mappers;

use App\Entities\Group;

// Seul endroit qui connaît les noms des colonnes SQL de groupe.
class GroupMapper
{
    public function mapToObject(array $row): Group
    {
        $group = new Group();

        $group->setId((int) $row['id_groupe']);
        $group->setNom((string) $row['nom']);
        $group->setIdCup((int) $row['id_cup']);

        return $group;
    }

    /** @return Group[] */
    public function mapToList(array $rows): array
    {
        return array_map(fn($row) => $this->mapToObject($row), $rows);
    }
}
