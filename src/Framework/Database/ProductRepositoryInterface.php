<?php

declare(strict_types=1);

namespace Framework\Database;

use App\Entities\Product;

// Contract for all product data access operations.
interface ProductRepositoryInterface extends RepositoryInterface
{
    /** @return Product[] */
    public function findAll(): array;

    public function findById(int $id): ?Product;

    // categoryId is nullable — a product can exist without a category.
    public function create(string $name, string $description, int $size, ?int $categoryId): int;

    public function update(int $id, string $name, string $description, int $size, ?int $categoryId): void;

    public function delete(int $id): void;
}
