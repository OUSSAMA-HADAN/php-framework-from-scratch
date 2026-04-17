<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Product;
use App\Mappers\ProductMapper;
use Framework\Database\DatabaseInterface;
use Framework\Database\ProductRepositoryInterface;

// Handles all database operations for the Product entity.
// Stored procedures handle the JOIN with category — no raw SQL built here.
class ProductRepository implements ProductRepositoryInterface
{
    private DatabaseInterface $database;
    private ProductMapper $mapper;

    public function __construct(DatabaseInterface $database, ProductMapper $mapper)
    {
        $this->database = $database;
        $this->mapper   = $mapper;
    }

    /** @return Product[] */
    public function findAll(): array
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare('CALL sp_get_all_products()');
        $stmt->execute();

        return $this->mapper->mapMany($stmt->fetchAll());
    }

    public function findById(int $id): ?Product
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare('CALL sp_get_product_by_id(?)');
        $stmt->execute([$id]);

        $row = $stmt->fetch();

        return $row !== false ? $this->mapper->map($row) : null;
    }

    // Passes category_id as a nullable parameter to the stored procedure.
    public function create(string $name, string $description, int $size, ?int $categoryId): int
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare('CALL sp_create_product(?, ?, ?, ?)');
        $stmt->execute([$name, $description, $size, $categoryId]);

        return (int) $pdo->lastInsertId();
    }

    public function update(int $id, string $name, string $description, int $size, ?int $categoryId): void
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare('CALL sp_update_product(?, ?, ?, ?, ?)');
        $stmt->execute([$id, $name, $description, $size, $categoryId]);
    }

    public function delete(int $id): void
    {
        $pdo  = $this->database->getConnection();
        $stmt = $pdo->prepare('CALL sp_delete_product(?)');
        $stmt->execute([$id]);
    }
}
