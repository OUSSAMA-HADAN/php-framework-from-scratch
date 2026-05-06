<?php

declare(strict_types=1);

namespace App\Entities;

// Représente un groupe au sein d'une cup (Groupe A, B, C...).
class Group
{
    private int    $id;
    private string $nom;    // lettre du groupe : 'A', 'B'...
    private int    $idCup;

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }

    public function getIdCup(): int { return $this->idCup; }
    public function setIdCup(int $idCup): void { $this->idCup = $idCup; }
}
