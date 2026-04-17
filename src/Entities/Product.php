<?php

declare(strict_types=1);

namespace App\Entities;

// Represents a product. Plain PHP object — no database knowledge.
class Product
{
    private int $id;
    private string $name;
    private string $description;
    private int $size;
    // Nullable — a product may not be assigned to a category yet.
    private ?int $categoryId = null;
    private ?string $categoryName = null;

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }

    public function getSize(): int { return $this->size; }
    public function setSize(int $size): void { $this->size = $size; }

    public function getCategoryId(): ?int { return $this->categoryId; }
    public function setCategoryId(?int $categoryId): void { $this->categoryId = $categoryId; }

    // Category name is resolved via JOIN in the stored procedure — not a separate query.
    public function getCategoryName(): ?string { return $this->categoryName; }
    public function setCategoryName(?string $categoryName): void { $this->categoryName = $categoryName; }
}
