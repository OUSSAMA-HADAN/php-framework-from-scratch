<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Category;
use App\Mappers\CategoryMapper;
use Framework\Database\CategoryRepositoryInterface;
use Framework\Database\DatabaseInterface;

// Handles all database operations for the Category entity.
class CategoryRepository implements CategoryRepositoryInterface
{
    private DatabaseInterface $database;
    private CategoryMapper $mapper;

    public function __construct(DatabaseInterface $database, CategoryMapper $mapper)
    {
        $this->database = $database;
        $this->mapper   = $mapper;
    }

    /** @return Category[] */
    public function findAll(): array
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare('CALL sp_get_all_categories()');
        $stmt->execute();

        return $this->mapper->mapMany($stmt->fetchAll());
    }

    public function findById(int $id): ?Category
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare('CALL sp_get_category_by_id(?)');
        $stmt->execute([$id]);

        $row = $stmt->fetch();

        return $row !== false ? $this->mapper->map($row) : null;
    }

    // Inserts a new category and returns the auto-generated ID.
    public function create(string $name, string $description): int
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare('CALL sp_create_category(?, ?)');
        $stmt->execute([$name, $description]);

        return (int) $pdo->lastInsertId();
    }

    // Updates an existing category record.
    public function update(int $id, string $name, string $description): void
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare('CALL sp_update_category(?, ?, ?)');
        $stmt->execute([$id, $name, $description]);
    }

    // Deletes a category by ID.
    public function delete(int $id): void
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare('CALL sp_delete_category(?)');
        $stmt->execute([$id]);
    }
}
