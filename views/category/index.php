<?php $this->layout('layout', ['title' => $category ? $category->getName() : 'Category Not Found']) ?>

<?php if ($category === null): ?>
    <!-- Not found state -->
    <div class="text-center py-5">
        <i class="bi bi-exclamation-circle display-4 text-danger d-block mb-3"></i>
        <h3 class="text-danger">Category Not Found</h3>
        <p class="text-muted">No category exists with that ID.</p>
        <a href="/categories" class="btn btn-success mt-2">
            <i class="bi bi-arrow-left me-1"></i>Back to Categories
        </a>
    </div>
<?php else: ?>
    <!-- Back link -->
    <a href="/categories" class="btn btn-outline-secondary btn-sm mb-4">
        <i class="bi bi-arrow-left me-1"></i>Back to Categories
    </a>

    <!-- Category detail card -->
    <div class="card" style="max-width: 600px;">
        <div class="card-header bg-success text-white py-3">
            <h4 class="mb-0 fw-bold"><i class="bi bi-tag me-2"></i><?= $this->e($category->getName()) ?></h4>
        </div>
        <div class="card-body p-4">
            <table class="table table-borderless mb-0">
                <tbody>
                    <tr>
                        <th class="text-muted ps-0" style="width:130px;">ID</th>
                        <td><?= $this->e((string) $category->getId()) ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted ps-0">Name</th>
                        <td><?= $this->e($category->getName()) ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted ps-0">Description</th>
                        <td><?= $this->e($category->getDescription()) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php endif ?>
