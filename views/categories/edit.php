<?php $this->layout('layout', ['title' => 'Edit ' . $category->getName()]) ?>

<a href="/categories" class="btn btn-outline-secondary btn-sm mb-4">
    <i class="bi bi-arrow-left me-1"></i>Back to Categories
</a>

<div class="card" style="max-width: 560px;">
    <div class="card-header bg-warning text-dark py-3">
        <h5 class="mb-0 fw-bold"><i class="bi bi-pencil me-2"></i>Edit Category</h5>
    </div>
    <div class="card-body p-4">
        <form action="/category/<?= $category->getId() ?>/update" method="POST">

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Name</label>
                <input type="text" id="name" name="name" class="form-control"
                       value="<?= $this->e($category->getName()) ?>" required autofocus>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3"><?= $this->e($category->getDescription()) ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-lg me-1"></i>Save Changes
                </button>
                <a href="/categories" class="btn btn-outline-secondary">Cancel</a>
            </div>

        </form>
    </div>
</div>
