<?php $this->layout('layout', ['title' => 'Cups']) ?>

<div class="mb-4">
    <p class="vf-section-title mb-1">Tournois</p>
    <h4 class="fw-bold mb-0 text-white">Cups ouvertes</h4>
</div>

<?php if (empty($cups)): ?>
    <div class="vf-card p-5 text-center">
        <i class="bi bi-trophy display-4 text-secondary mb-3 d-block"></i>
        <p class="text-secondary mb-0">Aucune cup disponible pour le moment.</p>
    </div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($cups as $cup): ?>
            <div class="col-md-6 col-lg-4">
                <div class="vf-card p-4 h-100 d-flex flex-column">

                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <h6 class="fw-bold text-white mb-0"><?= $this->e($cup->getTitre()) ?></h6>
                        <span class="vf-badge badge-<?= $this->e($cup->getStatut()) ?>">
                            <?= $this->e($cup->getStatut()) ?>
                        </span>
                    </div>

                    <div class="d-flex gap-3 mb-4 text-secondary" style="font-size:.82rem">
                        <span><i class="bi bi-people me-1"></i><?= $cup->getMinPlayers() ?>–<?= $cup->getMaxPlayers() ?> joueurs</span>
                        <span><i class="bi bi-person me-1"></i><?= $this->e($cup->getOrganisateur()) ?></span>
                    </div>

                    <a href="/cups/<?= $cup->getId() ?>" class="btn btn-vf-outline btn-sm mt-auto">
                        Voir la cup <i class="bi bi-arrow-right ms-1"></i>
                    </a>

                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>
