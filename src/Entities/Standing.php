<?php

declare(strict_types=1);

namespace App\Entities;

// Représente la ligne de classement d'un joueur dans un groupe.
class Standing
{
    private int    $idUser;
    private string $username;
    private int    $played;
    private int    $wins;
    private int    $draws;
    private int    $losses;
    private int    $goalsFor;
    private int    $goalsAgainst;
    private int    $points;

    public function getIdUser(): int { return $this->idUser; }
    public function setIdUser(int $idUser): void { $this->idUser = $idUser; }

    public function getUsername(): string { return $this->username; }
    public function setUsername(string $username): void { $this->username = $username; }

    public function getPlayed(): int { return $this->played; }
    public function setPlayed(int $played): void { $this->played = $played; }

    public function getWins(): int { return $this->wins; }
    public function setWins(int $wins): void { $this->wins = $wins; }

    public function getDraws(): int { return $this->draws; }
    public function setDraws(int $draws): void { $this->draws = $draws; }

    public function getLosses(): int { return $this->losses; }
    public function setLosses(int $losses): void { $this->losses = $losses; }

    public function getGoalsFor(): int { return $this->goalsFor; }
    public function setGoalsFor(int $goalsFor): void { $this->goalsFor = $goalsFor; }

    public function getGoalsAgainst(): int { return $this->goalsAgainst; }
    public function setGoalsAgainst(int $goalsAgainst): void { $this->goalsAgainst = $goalsAgainst; }

    public function getPoints(): int { return $this->points; }
    public function setPoints(int $points): void { $this->points = $points; }

    // Différence de buts — calculée à la volée, pas stockée en DB
    public function getGoalDiff(): int { return $this->goalsFor - $this->goalsAgainst; }
}
