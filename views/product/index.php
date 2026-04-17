<?php $this->layout('layout', ['title' => $product ? $product->getName() : 'Product Not Found']) ?>

<?php if ($product === null): ?>
    <div class="text-center py-5">
        <i class="bi bi-exclamation-circle display-4 text-danger d-block mb-3"></i>
        <h3 class="text-danger">Product Not Found</h3>
        <p class="text-muted">No product exists with that ID.</p>
        <a href="/products" class="btn btn-primary mt-2">
            <i class="bi bi-arrow-left me-1"></i>Back to Products
        </a>
    </div>
<?php else: ?>
    <a href="/products" class="btn btn-outline-secondary btn-sm mb-4">
        <i class="bi bi-arrow-left me-1"></i>Back to Products
    </a>

    <div class="card" style="max-width: 600px;">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i><?= $this->e($product->getName()) ?></h4>
        </div>
        <div class="card-body p-4">
            <table class="table table-borderless mb-0">
                <tbody>
                    <tr>
                        <th class="text-muted ps-0" style="width:130px;">ID</th>
                        <td><?= $this->e((string) $product->getId()) ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted ps-0">Name</th>
                        <td><?= $this->e($product->getName()) ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted ps-0">Description</th>
                        <td><?= $this->e($product->getDescription()) ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted ps-0">Size</th>
                        <td>
                            <span class="badge bg-secondary">
                                <i class="bi bi-rulers me-1"></i><?= $this->e((string) $product->getSize()) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted ps-0">Category</th>
                        <td>
                            <?php if ($product->getCategoryName()): ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-tag me-1"></i><?= $this->e($product->getCategoryName()) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted fst-italic">Uncategorised</span>
                            <?php endif ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-transparent d-flex gap-2 px-4 pb-3">
            <a href="/product/<?= $product->getId() ?>/edit" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <form action="/product/<?= $product->getId() ?>/delete" method="POST"
                  onsubmit="return confirm('Delete this product?')">
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash me-1"></i>Delete
                </button>
            </form>
        </div>
    </div>
<?php endif ?>
