<?php $this->layout('layout', ['title' => 'Mes Matches']) ?>

<div class="mb-4">
    <p class="vf-section-title mb-1">Terrain</p>
    <h4 class="fw-bold mb-0 text-white">Mes matches</h4>
</div>

<?php if (empty($matches)): ?>
    <div class="vf-card p-5 text-center">
        <i class="bi bi-lightning display-4 text-secondary mb-3 d-block"></i>
        <p class="text-secondary mb-0">Aucun match pour le moment.</p>
    </div>
<?php else: ?>
    <div class="vf-card">
        <table class="table vf-table mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Cup</th>
                    <th>Phase</th>
                    <th>Domicile</th>
                    <th class="text-center">Score</th>
                    <th>Extérieur</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($matches as $m): ?>
                    <tr>
                        <td class="ps-4">
                            <small class="text-secondary"><?= $this->e($m->getCupTitre()) ?></small>
                        </td>
                        <td>
                            <small class="text-secondary"><?= $this->e($m->getRound()) ?> · leg <?= $this->e($m->getLeg()) ?></small>
                        </td>
                        <td class="fw-semibold text-white"><?= $this->e($m->getHomeName()) ?></td>
                        <td class="text-center fw-bold" style="letter-spacing:2px;color:var(--vf-green)">
                            <?php if ($m->getResultHome() !== null): ?>
                                <?= $m->getResultHome() ?> – <?= $m->getResultAway() ?>
                            <?php else: ?>
                                <span class="text-secondary">–</span>
                            <?php endif ?>
                        </td>
                        <td class="fw-semibold text-white"><?= $this->e($m->getAwayName()) ?></td>
                        <td>
                            <span class="vf-badge badge-<?= $this->e($m->getStatut()) ?>">
                                <?= $this->e($m->getStatut()) ?>
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <a href="/matches/<?= $m->getId() ?>" class="btn btn-vf-outline btn-sm">
                                Voir
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?php endif ?>
