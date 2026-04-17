<?php

declare(strict_types=1);

namespace App\Mappers;

use App\Entities\Category;

// Converts raw PDO result rows into Category entity objects.
// The only place that knows both DB column names and entity setters for Category.
class CategoryMapper
{
    // Hydrates a single Category entity from one associative PDO row.
    public function map(array $row): Category
    {
        $category = new Category();

        $category->setId((int) $row['id']);
        $category->setName((string) $row['name']);
        $category->setDescription((string) $row['description']);

        return $category;
    }

    // Maps an entire result set into an array of Category entities.
    /** @return Category[] */
    public function mapMany(array $rows): array
    {
        return array_map(fn(array $row) => $this->map($row), $rows);
    }
}
