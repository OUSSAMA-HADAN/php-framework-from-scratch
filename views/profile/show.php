<?php $this->layout('layout', ['title' => 'Mon Profil']) ?>

<?php
    $played    = count($matches);
    $confirmed = array_filter($matches, fn($m) => $m->getStatut() === 'confirmed');
    $pending   = array_filter($matches, fn($m) => $m->getStatut() === 'pending');
?>

<div class="mb-4">
    <p class="vf-section-title mb-1">Compte</p>
    <h4 class="fw-bold mb-0 text-white">Mon profil</h4>
</div>

<!-- Stats row -->
<div class="row g-3 mb-4">
    <div class="col-4">
        <div class="vf-card p-4 text-center">
            <div class="fw-bold text-white" style="font-size:2rem"><?= $played ?></div>
            <small class="text-secondary">Matches</small>
        </div>
    </div>
    <div class="col-4">
        <div class="vf-card p-4 text-center">
            <div class="fw-bold text-white" style="font-size:2rem"><?= count($confirmed) ?></div>
            <small class="text-secondary">Confirmés</small>
        </div>
    </div>
    <div class="col-4">
        <div class="vf-card p-4 text-center">
            <div class="fw-bold" style="font-size:2rem;color:var(--vf-green)"><?= count($pending) ?></div>
            <small class="text-secondary">En attente</small>
        </div>
    </div>
</div>

<!-- Recent matches -->
<div class="vf-card p-4">
    <p class="vf-section-title mb-3">Derniers matches</p>

    <?php if (empty($matches)): ?>
        <p class="text-secondary mb-0">Aucun match pour le moment.</p>
    <?php else: ?>
        <div class="d-flex flex-column gap-2">
            <?php foreach (array_slice($matches, 0, 8) as $m): ?>
                <a href="/matches/<?= $m->getId() ?>" class="text-decoration-none">
                    <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background:#0d0f14;border:1px solid var(--vf-border);transition:border-color .2s" onmouseover="this.style.borderColor='var(--vf-green)'" onmouseout="this.style.borderColor='var(--vf-border)'">
                        <div>
                            <div class="fw-semibold text-white" style="font-size:.9rem">
                                <?= $this->e($m->getHomeName()) ?> <span class="text-secondary mx-1">vs</span> <?= $this->e($m->getAwayName()) ?>
                            </div>
                            <small class="text-secondary"><?= $this->e($m->getCupTitre()) ?> · <?= $this->e($m->getRound()) ?></small>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <?php if ($m->getResultHome() !== null): ?>
                                <span class="fw-bold" style="color:var(--vf-green)">
                                    <?= $m->getResultHome() ?> – <?= $m->getResultAway() ?>
                                </span>
                            <?php endif ?>
                            <span class="vf-badge badge-<?= $this->e($m->getStatut()) ?>">
                                <?= $this->e($m->getStatut()) ?>
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>
