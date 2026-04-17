<?php

declare(strict_types=1);

namespace App\Mappers;

use App\Entities\User;

// Converts raw PDO result rows into User entity objects.
// The only place that knows both DB column names and User entity setters.
class UserMapper
{
    // Hydrates a single User entity from one associative PDO row.
    public function map(array $row): User
    {
        $user = new User();

        $user->setId((int) $row['id']);
        $user->setEmail((string) $row['email']);
        // Store the hash as-is — password_verify() will compare it later.
        $user->setPassword((string) $row['password']);

        return $user;
    }
}
