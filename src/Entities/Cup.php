<?php

declare(strict_types=1);

namespace App\Entities;

// Représente un tournoi (cup) — plain PHP object, aucune connaissance DB.
class Cup
{
    private int    $id;
    private string $titre;
    private string $statut;        // draft | open | started | finished | cancelled
    private string $visibilite;    // public | private
    private int    $minPlayers;
    private int    $maxPlayers;
    private int    $qualification; // nombre de qualifiés par groupe
    private string $organisateur;  // username du créateur

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getTitre(): string { return $this->titre; }
    public function setTitre(string $titre): void { $this->titre = $titre; }

    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $statut): void { $this->statut = $statut; }

    public function getVisibilite(): string { return $this->visibilite; }
    public function setVisibilite(string $visibilite): void { $this->visibilite = $visibilite; }

    public function getMinPlayers(): int { return $this->minPlayers; }
    public function setMinPlayers(int $minPlayers): void { $this->minPlayers = $minPlayers; }

    public function getMaxPlayers(): int { return $this->maxPlayers; }
    public function setMaxPlayers(int $maxPlayers): void { $this->maxPlayers = $maxPlayers; }

    public function getQualification(): int { return $this->qualification; }
    public function setQualification(int $qualification): void { $this->qualification = $qualification; }

    public function getOrganisateur(): string { return $this->organisateur; }
    public function setOrganisateur(string $organisateur): void { $this->organisateur = $organisateur; }
}