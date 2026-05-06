<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title) ?> — VFoot Arena</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --vf-green:  #00c46a;
            --vf-dark:   #0d0f14;
            --vf-card:   #151820;
            --vf-border: rgba(255,255,255,.07);
        }

        body {
            background-color: var(--vf-dark);
            color: #e2e8f0;
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background: #0a0c10 !important;
            border-bottom: 1px solid var(--vf-border);
        }
        .navbar-brand {
            font-weight: 800;
            letter-spacing: 1.5px;
            color: var(--vf-green) !important;
            font-size: 1.2rem;
        }
        .nav-link { color: #94a3b8 !important; font-size: .9rem; }
        .nav-link:hover, .nav-link.active { color: #fff !important; }
        .nav-link.text-danger { color: #f87171 !important; }

        /* Cards */
        .vf-card {
            background: var(--vf-card);
            border: 1px solid var(--vf-border);
            border-radius: 12px;
            transition: border-color .2s, transform .15s;
        }
        .vf-card:hover { border-color: var(--vf-green); transform: translateY(-2px); }

        /* Badges */
        .badge-open      { background: rgba(0,196,106,.15); color: var(--vf-green); }
        .badge-started   { background: rgba(59,130,246,.15); color: #60a5fa; }
        .badge-finished  { background: rgba(148,163,184,.1); color: #94a3b8; }
        .badge-pending   { background: rgba(251,191,36,.12); color: #fbbf24; }
        .badge-confirmed { background: rgba(0,196,106,.15);  color: var(--vf-green); }
        .badge-disputed  { background: rgba(239,68,68,.15);  color: #f87171; }

        .vf-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* Buttons */
        .btn-vf {
            background: var(--vf-green);
            color: #000;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
        }
        .btn-vf:hover { background: #00a857; color: #000; }
        .btn-vf-outline {
            border: 1px solid var(--vf-green);
            color: var(--vf-green);
            background: transparent;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
        }
        .btn-vf-outline:hover { background: var(--vf-green); color: #000; }

        /* Forms */
        .form-control, .form-select {
            background: #0d0f14;
            border: 1px solid var(--vf-border);
            color: #e2e8f0;
            border-radius: 8px;
        }
        .form-control:focus, .form-select:focus {
            background: #0d0f14;
            border-color: var(--vf-green);
            color: #e2e8f0;
            box-shadow: 0 0 0 3px rgba(0,196,106,.15);
        }
        .form-label { color: #94a3b8; font-size: .85rem; font-weight: 600; }

        /* Table */
        .vf-table { color: #e2e8f0; }
        .vf-table th { color: #64748b; font-size: .75rem; text-transform: uppercase; letter-spacing: .8px; border-color: var(--vf-border); }
        .vf-table td { border-color: var(--vf-border); vertical-align: middle; }

        /* Divider */
        .vf-divider { border-color: var(--vf-border); }

        /* Section title */
        .vf-section-title { font-size: .7rem; text-transform: uppercase; letter-spacing: 1.5px; color: #64748b; font-weight: 700; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container">
            <a class="navbar-brand" href="/cups">
                <i class="bi bi-controller me-2"></i>VFOOT
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto gap-1">
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/cups"><i class="bi bi-trophy me-1"></i>Cups</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/matches"><i class="bi bi-lightning me-1"></i>Matches</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/profile"><i class="bi bi-person me-1"></i>Profile</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="nav-link text-danger" href="/logout"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
                        </li>
                    <?php else: ?>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
