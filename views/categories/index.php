<?php $this->layout('layout', ['title' => 'Categories']) ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h2 class="fw-bold mb-0"><i class="bi bi-tags me-2 text-success"></i>Categories</h2>
    <div>
        <span class="badge bg-success fs-6 me-2"><?= count($categories) ?> items</span>
        <a href="/categories/create" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg me-1"></i>New Category
        </a>
    </div>
</div>

<?php if (empty($categories)): ?>
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox display-4 d-block mb-3"></i>
        <p class="fs-5">No categories found.</p>
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($categories as $category): ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold">
                            <i class="bi bi-tag text-success me-1"></i>
                            <?= $this->e($category->getName()) ?>
                        </h5>
                        <p class="card-text text-muted"><?= $this->e($category->getDescription()) ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3 px-4 d-flex gap-2">
                        <a href="/category/<?= $category->getId() ?>" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-eye me-1"></i>View
                        </a>
                        <a href="/category/<?= $category->getId() ?>/edit" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form action="/category/<?= $category->getId() ?>/delete" method="POST"
                              onsubmit="return confirm('Delete this category?')">
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>
