<?php

declare(strict_types=1);

namespace Framework\Database;

use App\Entities\User;

// Contract for all user data access operations.
interface UserRepositoryInterface extends RepositoryInterface
{
    // Finds a user by their email address — used during login to retrieve the stored hash.
    public function findByEmail(string $email): ?User;

    // Finds a user by their ID — used to rehydrate the user from the session.
    public function findById(int $id): ?User;

    // Creates a new user with the given email, username and bcrypt-hashed password.
    public function create(string $email, string $username, string $hashedPassword): void;
}
