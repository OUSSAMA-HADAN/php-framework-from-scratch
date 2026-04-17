<?php

declare(strict_types=1);

namespace App\Mappers;

use App\Entities\Product;

// Converts raw PDO result rows into Product entity objects.
// The only place that knows both DB column names and entity setters for Product.
class ProductMapper
{
    // Hydrates a single Product entity from one associative PDO row.
    public function map(array $row): Product
    {
        $product = new Product();

        $product->setId((int) $row['id']);
        $product->setName((string) $row['name']);
        $product->setDescription((string) $row['description']);
        $product->setSize((int) $row['size']);
        // category_id and category_name come from the LEFT JOIN in the stored procedure.
        $product->setCategoryId(isset($row['category_id']) ? (int) $row['category_id'] : null);
        $product->setCategoryName(isset($row['category_name']) ? (string) $row['category_name'] : null);

        return $product;
    }

    /** @return Product[] */
    public function mapMany(array $rows): array
    {
        return array_map(fn(array $row) => $this->map($row), $rows);
    }
}
