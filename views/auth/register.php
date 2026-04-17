<?php $this->layout('layout', ['title' => 'Register']) ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white text-center py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-person-plus me-2"></i>Create Account</h5>
            </div>
            <div class="card-body p-4">

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <?= $this->e($error) ?>
                    </div>
                <?php endif ?>

                <form action="/register" method="POST">

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                               placeholder="you@example.com" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                               placeholder="••••••••" required>
                    </div>

                    <div class="mb-4">
                        <label for="confirm" class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" id="confirm" name="confirm" class="form-control"
                               placeholder="••••••••" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark btn-lg">
                            <i class="bi bi-person-check me-1"></i>Create Account
                        </button>
                    </div>

                </form>
            </div>
            <div class="card-footer text-center text-muted py-3">
                Already have an account? <a href="/login">Sign in</a>
            </div>
        </div>
    </div>
</div>
