<?php

declare(strict_types=1);

namespace App\Entities;

// Represents an authenticated user.
// Plain PHP object — no database knowledge, only data and accessors.
class User
{
    private int $id;
    private string $email;
    // Stores the bcrypt hash — never the plain-text password.
    private string $password;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
