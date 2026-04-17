<?php $this->layout('layout', ['title' => 'New Category']) ?>

<a href="/categories" class="btn btn-outline-secondary btn-sm mb-4">
    <i class="bi bi-arrow-left me-1"></i>Back to Categories
</a>

<div class="card" style="max-width: 560px;">
    <div class="card-header bg-success text-white py-3">
        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>New Category</h5>
    </div>
    <div class="card-body p-4">
        <form action="/categories" method="POST">

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Name</label>
                <input type="text" id="name" name="name" class="form-control" required autofocus>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>Create Category
                </button>
                <a href="/categories" class="btn btn-outline-secondary">Cancel</a>
            </div>

        </form>
    </div>
</div>
