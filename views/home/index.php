<?php $this->layout('layout', ['title' => 'Home']) ?>

<!-- Hero section -->
<div class="p-5 mb-4 bg-dark text-white rounded-3">
    <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold"><i class="bi bi-shop me-2"></i>ShopFrame</h1>
        <p class="col-md-8 fs-4">A lightweight PHP mini framework — clean, fast, no ORM.</p>
        <p class="mb-4">Good <?= $this->e($name) ?>! Ready to browse?</p>
        <a href="/products" class="btn btn-primary btn-lg me-2">
            <i class="bi bi-box-seam me-1"></i>View Products
        </a>
        <a href="/categories" class="btn btn-outline-light btn-lg">
            <i class="bi bi-tags me-1"></i>View Categories
        </a>
    </div>
</div>

<!-- Quick links -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body p-4">
                <h5 class="card-title"><i class="bi bi-box-seam text-primary me-2"></i>Products</h5>
                <p class="card-text text-muted">Browse all available products in the catalogue.</p>
                <a href="/products" class="btn btn-primary">Go to Products</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body p-4">
                <h5 class="card-title"><i class="bi bi-tags text-success me-2"></i>Categories</h5>
                <p class="card-text text-muted">Explore product categories and collections.</p>
                <a href="/categories" class="btn btn-success">Go to Categories</a>
            </div>
        </div>
    </div>
</div>
