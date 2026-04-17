<?php $this->layout('layout', ['title' => 'Products']) ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h2 class="fw-bold mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Products</h2>
    <div>
        <span class="badge bg-primary fs-6 me-2"><?= count($products) ?> items</span>
        <a href="/products/create" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>New Product
        </a>
    </div>
</div>

<?php if (empty($products)): ?>
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox display-4 d-block mb-3"></i>
        <p class="fs-5">No products found.</p>
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold"><?= $this->e($product->getName()) ?></h5>
                        <p class="card-text text-muted"><?= $this->e($product->getDescription()) ?></p>
                        <div class="d-flex gap-2 flex-wrap mt-2">
                            <span class="badge bg-secondary">
                                <i class="bi bi-rulers me-1"></i>Size: <?= $this->e((string) $product->getSize()) ?>
                            </span>
                            <!-- Category badge — shown only when a category is assigned -->
                            <?php if ($product->getCategoryName()): ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-tag me-1"></i><?= $this->e($product->getCategoryName()) ?>
                                </span>
                            <?php else: ?>
                                <span class="badge bg-light text-muted border">Uncategorised</span>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3 px-4 d-flex gap-2">
                        <a href="/product/<?= $product->getId() ?>" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>View
                        </a>
                        <a href="/product/<?= $product->getId() ?>/edit" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form action="/product/<?= $product->getId() ?>/delete" method="POST"
                              onsubmit="return confirm('Delete this product?')">
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
