<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;
use App\Mappers\UserMapper;
use Framework\Database\DatabaseInterface;
use Framework\Database\UserRepositoryInterface;

// Handles all database operations for the User entity.
// Calls stored procedures defined in the database — no raw SQL built here.
class UserRepository implements UserRepositoryInterface
{
    // Shared PDO connection injected by the DI container.
    private DatabaseInterface $database;

    // Mapper that converts raw PDO rows into User entities.
    private UserMapper $mapper;

    // PHP-DI resolves and injects both dependencies via constructor.
    public function __construct(DatabaseInterface $database, UserMapper $mapper)
    {
        $this->database = $database;
        $this->mapper   = $mapper;
    }

    // Finds a user by email — called by AuthController during login.
    public function findByEmail(string $email): ?User
    {
        $pdo  = $this->database->getConnection();

        $stmt = $pdo->prepare('CALL sp_get_user_by_email(?)');
        $stmt->execute([$email]);

        $row = $stmt->fetch();

        return $row !== false ? $this->mapper->map($row) : null;
    }

    // Finds a user by ID — called by AuthMiddleware to verify the session is still valid.
    public function findById(int $id): ?User
    {
        $pdo  = $this->database->getConnection();

        $stmt = $pdo->prepare('CALL sp_get_user_by_id(?)');
        $stmt->execute([$id]);

        $row = $stmt->fetch();

        return $row !== false ? $this->mapper->map($row) : null;
    }

    // Inserts a new user record via the stored procedure sp_create_user.
    // Password must already be bcrypt-hashed before calling this method.
    public function create(string $email, string $hashedPassword): void
    {
        $pdo  = $this->database->getConnection();

        $stmt = $pdo->prepare('CALL sp_create_user(?, ?)');
        $stmt->execute([$email, $hashedPassword]);
    }
}
