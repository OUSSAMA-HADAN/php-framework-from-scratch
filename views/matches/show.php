<?php $this->layout('layout', ['title' => 'Match']) ?>

<?php
    $status  = $_GET['status'] ?? null;
    $isHome  = $matche->getHomeUserId() === $userId;
    $isAway  = $matche->getAwayUserId() === $userId;
    $canPlay = in_array($matche->getStatut(), ['pending', 'submitted', 'disputed']);
?>

<div class="mb-4">
    <a href="/matches" class="text-secondary text-decoration-none" style="font-size:.85rem">
        <i class="bi bi-arrow-left me-1"></i>Mes matches
    </a>
</div>

<!-- Status notification -->
<?php if ($status === 'confirmed'): ?>
    <div class="alert border-0 mb-4" style="background:rgba(0,196,106,.12);color:var(--vf-green);border-radius:10px">
        <i class="bi bi-check-circle me-2"></i>Score confirmé — les deux joueurs sont d'accord.
    </div>
<?php elseif ($status === 'waiting'): ?>
    <div class="alert border-0 mb-4" style="background:rgba(251,191,36,.1);color:#fbbf24;border-radius:10px">
        <i class="bi bi-hourglass me-2"></i>Score soumis — en attente de la confirmation adverse.
    </div>
<?php elseif ($status === 'disputed'): ?>
    <div class="alert border-0 mb-4" style="background:rgba(239,68,68,.12);color:#f87171;border-radius:10px">
        <i class="bi bi-exclamation-triangle me-2"></i>Litige — les scores ne correspondent pas. Un admin va trancher.
    </div>
<?php endif ?>

<!-- Match card -->
<div class="vf-card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <small class="text-secondary"><?= $this->e($matche->getCupTitre()) ?> · <?= $this->e($matche->getRound()) ?> · leg <?= $this->e($matche->getLeg()) ?></small>
        <span class="vf-badge badge-<?= $this->e($matche->getStatut()) ?>"><?= $this->e($matche->getStatut()) ?></span>
    </div>

    <!-- Score display -->
    <div class="d-flex align-items-center justify-content-center gap-4 py-3">
        <div class="text-center flex-fill">
            <p class="fw-bold text-white fs-5 mb-0"><?= $this->e($matche->getHomeName()) ?></p>
            <?php if ($isHome): ?><small style="color:var(--vf-green)">Vous</small><?php endif ?>
        </div>

        <div class="text-center px-4">
            <?php if ($matche->getResultHome() !== null): ?>
                <div class="fw-bold" style="font-size:2.5rem;letter-spacing:6px;color:var(--vf-green);line-height:1">
                    <?= $matche->getResultHome() ?> <span style="color:#334155">–</span> <?= $matche->getResultAway() ?>
                </div>
            <?php else: ?>
                <div class="fw-bold" style="font-size:2rem;letter-spacing:4px;color:#334155">? – ?</div>
            <?php endif ?>
        </div>

        <div class="text-center flex-fill">
            <p class="fw-bold text-white fs-5 mb-0"><?= $this->e($matche->getAwayName()) ?></p>
            <?php if ($isAway): ?><small style="color:var(--vf-green)">Vous</small><?php endif ?>
        </div>
    </div>
</div>

<!-- Submit score form — only if player is in this match and match is still playable -->
<?php if (($isHome || $isAway) && $canPlay): ?>
    <div class="vf-card p-4">
        <p class="vf-section-title mb-3">Soumettre votre score</p>

        <form action="/matches/<?= $matche->getId() ?>/score" method="POST">
            <div class="row g-3 align-items-end">
                <div class="col">
                    <label class="form-label"><?= $this->e($matche->getHomeName()) ?> (domicile)</label>
                    <input type="number" name="home_score" class="form-control text-center fw-bold fs-5"
                           value="0" min="0" max="99" required>
                </div>
                <div class="col-auto pb-2">
                    <span class="text-secondary fw-bold">–</span>
                </div>
                <div class="col">
                    <label class="form-label"><?= $this->e($matche->getAwayName()) ?> (extérieur)</label>
                    <input type="number" name="away_score" class="form-control text-center fw-bold fs-5"
                           value="0" min="0" max="99" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-vf">
                        <i class="bi bi-send me-1"></i>Soumettre
                    </button>
                </div>
            </div>
        </form>
    </div>
<?php endif ?>
