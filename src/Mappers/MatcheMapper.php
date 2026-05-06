<?php

declare(strict_types=1);

namespace App\Mappers;

use App\Entities\Matche;

// Seul endroit qui connaît les noms des colonnes SQL de matche.
class MatcheMapper
{
    public function mapToObject(array $row): Matche
    {
        $matche = new Matche();

        $matche->setId((int) $row['id_match']);
        $matche->setRound((string) $row['round']);
        $matche->setLeg((string) $row['leg']);
        $matche->setStatut((string) $row['statut']);
        $matche->setHomeName((string) $row['home_name']);
        $matche->setAwayName((string) $row['away_name']);
        $matche->setHomeUserId((int) $row['home_user_id']);
        $matche->setAwayUserId((int) $row['away_user_id']);
        $matche->setCupTitre((string) $row['cup_titre']);

        // Nullable — null si le match n'est pas encore confirmé
        $matche->setResultHome(isset($row['result_home']) ? (int) $row['result_home'] : null);
        $matche->setResultAway(isset($row['result_away']) ? (int) $row['result_away'] : null);

        return $matche;
    }

    /** @return Matche[] */
    public function mapToList(array $rows): array
    {
        return array_map(fn($row) => $this->mapToObject($row), $rows);
    }
}
