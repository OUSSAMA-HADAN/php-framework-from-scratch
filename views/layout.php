<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title) ?> — Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,.07); transition: transform .15s; }
        .card:hover { transform: translateY(-3px); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="bi bi-shop me-2"></i>ShopFrame</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="bi bi-house me-1"></i>Home</a>
                    </li>

                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <!-- Logged-in links -->
                        <li class="nav-item">
                            <a class="nav-link" href="/products"><i class="bi bi-box-seam me-1"></i>Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/categories"><i class="bi bi-tags me-1"></i>Categories</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="nav-link text-danger" href="/logout"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
                        </li>
                    <?php else: ?>
                        <!-- Guest links -->
                        <li class="nav-item">
                            <a class="nav-link" href="/login"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register"><i class="bi bi-person-plus me-1"></i>Register</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container pb-5">
        <?= $this->section('content') ?>
    </main>

    <footer class="bg-dark text-secondary text-center py-3 mt-auto">
        <small>ShopFrame &copy; <?= date('Y') ?> — PHP Mini Framework</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
