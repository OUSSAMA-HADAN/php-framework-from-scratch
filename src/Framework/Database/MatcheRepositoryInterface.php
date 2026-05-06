<?php

declare(strict_types=1);

namespace Framework\Database;

use App\Entities\Matche;

// Contrat pour toutes les opérations de données sur les matchs.
interface MatcheRepositoryInterface extends RepositoryInterface
{
    // Retourne tous les matchs d'un joueur (en attente en premier).
    public function findByUser(int $idUser): array;

    // Retourne tous les matchs d'un groupe.
    public function findByGroup(int $idGroupe): array;

    // Retourne tous les matchs knockout d'une cup, groupés par round.
    public function findKnockoutByCup(int $idCup): array;

    // Retourne tous les matchs en litige.
    public function findDisputed(): array;

    // Crée un nouveau match et retourne l'objet créé.
    public function create(
        string $round,
        string $leg,
        int    $idCup,
        ?int   $idGroupe,
        int    $homeUserId,
        int    $awayUserId
    ): Matche;

    // Soumet le score d'un joueur — retourne 'waiting', 'confirmed' ou 'disputed'.
    public function submitScore(
        int $idMatch,
        int $idUser,
        int $homeScore,
        int $awayScore
    ): string;
}
