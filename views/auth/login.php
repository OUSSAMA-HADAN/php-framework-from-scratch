<?php $this->layout('layout', ['title' => 'Login']) ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">

        <!-- Login card -->
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white text-center py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-lock me-2"></i>Sign In</h5>
            </div>
            <div class="card-body p-4">

                <!-- Error alert — shown only when credentials are invalid -->
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <?= $this->e($error) ?>
                    </div>
                <?php endif ?>

                <!-- Login form — posts to /login -->
                <form action="/login" method="POST">

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="admin@shop.com"
                            required
                            autofocus
                        >
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="••••••••"
                            required
                        >
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark btn-lg">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Sign In
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
