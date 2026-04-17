<?php

declare(strict_types=1);

namespace Framework\Database;

use App\Entities\Category;

// Contract for all category data access operations.
interface CategoryRepositoryInterface extends RepositoryInterface
{
    /** @return Category[] */
    public function findAll(): array;

    public function findById(int $id): ?Category;

    // Inserts a new category and returns its generated ID.
    public function create(string $name, string $description): int;

    // Updates an existing category by ID.
    public function update(int $id, string $name, string $description): void;

    // Deletes a category by ID.
    public function delete(int $id): void;
}
