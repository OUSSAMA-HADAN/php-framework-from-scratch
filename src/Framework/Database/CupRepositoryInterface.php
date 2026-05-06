<?php

declare(strict_types=1);

namespace Framework\Database;

use App\Entities\Cup;

// Contrat pour toutes les opérations de données sur les cups.
interface CupRepositoryInterface extends RepositoryInterface
{
    // Retourne toutes les cups de la plateforme.
    public function findAll(): array;

    // Retourne une cup par son id — null si introuvable.
    public function findById(int $id): ?Cup;

    // Retourne uniquement les cups publiques ouvertes (page d'accueil).
    public function findOpenCups(): array;

    // Crée une nouvelle cup et retourne l'objet créé.
    public function create(
        string  $titre,
        string  $visibilite,
        ?string $joinCode,
        int     $minPlayers,
        int     $maxPlayers,
        int     $createdBy
    ): Cup;

    // Met à jour le statut d'une cup (open, started, finished...).
    public function updateStatut(int $id, string $statut): void;

    // Vérifie si un joueur participe déjà à une cup.
    public function isParticipant(int $idCup, int $idUser): bool;

    // Inscrit un joueur dans une cup.
    public function join(int $idCup, int $idUser): void;

    // Retourne la liste des participants d'une cup.
    public function getParticipants(int $idCup): array;
}
