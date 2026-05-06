<?php $this->layout('layout', ['title' => 'Connexion']) ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="vf-card p-4">
            <p class="vf-section-title mb-1">Connexion</p>
            <h5 class="fw-bold text-white mb-4">Bienvenue sur VFoot</h5>

            <?php if (!empty($error)): ?>
                <div class="alert border-0 mb-4" style="background:rgba(239,68,68,.12);color:#f87171;border-radius:8px">
                    <i class="bi bi-exclamation-triangle me-2"></i><?= $this->e($error) ?>
                </div>
            <?php endif ?>

            <form action="/login" method="POST">

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           placeholder="toi@exemple.com" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-vf w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                </button>

            </form>

            <p class="text-center text-secondary mt-3 mb-0" style="font-size:.85rem">
                Pas encore de compte ? <a href="/register" style="color:var(--vf-green)">S'inscrire</a>
            </p>
        </div>
    </div>
</div>
