<?php

declare(strict_types=1);

namespace App\Entities;

// Représente un match entre deux joueurs.
// resultHome/resultAway sont nullable — null si pas encore confirmé.
class Matche
{
    private int     $id;
    private string  $round;        // group | R16 | QF | SF | F
    private string  $leg;          // 1 | 2 | 3 | single
    private string  $statut;       // pending | submitted | disputed | confirmed | forfeited
    private string  $homeName;
    private string  $awayName;
    private int     $homeUserId;
    private int     $awayUserId;
    private string  $cupTitre;
    private ?int    $resultHome;   // null si match pas encore confirmé
    private ?int    $resultAway;

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getRound(): string { return $this->round; }
    public function setRound(string $round): void { $this->round = $round; }

    public function getLeg(): string { return $this->leg; }
    public function setLeg(string $leg): void { $this->leg = $leg; }

    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $statut): void { $this->statut = $statut; }

    public function getHomeName(): string { return $this->homeName; }
    public function setHomeName(string $homeName): void { $this->homeName = $homeName; }

    public function getAwayName(): string { return $this->awayName; }
    public function setAwayName(string $awayName): void { $this->awayName = $awayName; }

    public function getHomeUserId(): int { return $this->homeUserId; }
    public function setHomeUserId(int $homeUserId): void { $this->homeUserId = $homeUserId; }

    public function getAwayUserId(): int { return $this->awayUserId; }
    public function setAwayUserId(int $awayUserId): void { $this->awayUserId = $awayUserId; }

    public function getCupTitre(): string { return $this->cupTitre; }
    public function setCupTitre(string $cupTitre): void { $this->cupTitre = $cupTitre; }

    public function getResultHome(): ?int { return $this->resultHome; }
    public function setResultHome(?int $resultHome): void { $this->resultHome = $resultHome; }

    public function getResultAway(): ?int { return $this->resultAway; }
    public function setResultAway(?int $resultAway): void { $this->resultAway = $resultAway; }
}
