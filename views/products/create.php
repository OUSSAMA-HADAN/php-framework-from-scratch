<?php $this->layout('layout', ['title' => 'New Product']) ?>

<a href="/products" class="btn btn-outline-secondary btn-sm mb-4">
    <i class="bi bi-arrow-left me-1"></i>Back to Products
</a>

<div class="card" style="max-width: 560px;">
    <div class="card-header bg-primary text-white py-3">
        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>New Product</h5>
    </div>
    <div class="card-body p-4">
        <form action="/products" method="POST">

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Name</label>
                <input type="text" id="name" name="name" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="size" class="form-label fw-semibold">Size</label>
                <input type="number" id="size" name="size" class="form-control" min="0" required>
            </div>

            <div class="mb-4">
                <label for="category_id" class="form-label fw-semibold">Category</label>
                <select id="category_id" name="category_id" class="form-select">
                    <option value="">— No category —</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->getId() ?>">
                            <?= $this->e($category->getName()) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Create Product
                </button>
                <a href="/products" class="btn btn-outline-secondary">Cancel</a>
            </div>

        </form>
    </div>
</div>
