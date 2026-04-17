<?php $this->layout('layout', ['title' => 'Edit ' . $product->getName()]) ?>

<a href="/products" class="btn btn-outline-secondary btn-sm mb-4">
    <i class="bi bi-arrow-left me-1"></i>Back to Products
</a>

<div class="card" style="max-width: 560px;">
    <div class="card-header bg-warning text-dark py-3">
        <h5 class="mb-0 fw-bold"><i class="bi bi-pencil me-2"></i>Edit Product</h5>
    </div>
    <div class="card-body p-4">
        <form action="/product/<?= $product->getId() ?>/update" method="POST">

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Name</label>
                <input type="text" id="name" name="name" class="form-control"
                       value="<?= $this->e($product->getName()) ?>" required autofocus>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3"><?= $this->e($product->getDescription()) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="size" class="form-label fw-semibold">Size</label>
                <input type="number" id="size" name="size" class="form-control" min="0"
                       value="<?= $product->getSize() ?>" required>
            </div>

            <div class="mb-4">
                <label for="category_id" class="form-label fw-semibold">Category</label>
                <select id="category_id" name="category_id" class="form-select">
                    <option value="">— No category —</option>
                    <?php foreach ($categories as $category): ?>
                        <!-- Mark the product's current category as selected -->
                        <option value="<?= $category->getId() ?>"
                            <?= $category->getId() === $product->getCategoryId() ? 'selected' : '' ?>>
                            <?= $this->e($category->getName()) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-lg me-1"></i>Save Changes
                </button>
                <a href="/products" class="btn btn-outline-secondary">Cancel</a>
            </div>

        </form>
    </div>
</div>
