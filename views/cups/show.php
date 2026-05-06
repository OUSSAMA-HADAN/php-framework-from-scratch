<?php $this->layout('layout', ['title' => $cup->getTitre()]) ?>

<!-- Header -->
<div class="vf-card p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <p class="vf-section-title mb-1"><i class="bi bi-trophy me-1"></i>Cup</p>
            <h4 class="fw-bold text-white mb-1"><?= $this->e($cup->getTitre()) ?></h4>
            <small class="text-secondary">
                Organisé par <strong class="text-white"><?= $this->e($cup->getOrganisateur()) ?></strong>
                &nbsp;·&nbsp;
                <?= $cup->getMinPlayers() ?>–<?= $cup->getMaxPlayers() ?> joueurs
            </small>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="vf-badge badge-<?= $this->e($cup->getStatut()) ?>" style="font-size:.85rem;padding:6px 14px">
                <?= $this->e($cup->getStatut()) ?>
            </span>
            <?php if ($cup->getStatut() === 'open'): ?>
                <?php if ($isParticipant): ?>
                    <span class="vf-badge badge-confirmed" style="font-size:.85rem;padding:6px 14px">
                        <i class="bi bi-check-lg me-1"></i>Inscrit
                    </span>
                <?php else: ?>
                    <form action="/cups/<?= $cup->getId() ?>/join" method="POST">
                        <button type="submit" class="btn btn-vf btn-sm">
                            <i class="bi bi-plus-lg me-1"></i>Rejoindre
                        </button>
                    </form>
                <?php endif ?>
            <?php endif ?>
        </div>
    </div>
</div>

<!-- Participants -->
<div class="vf-card p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="vf-section-title mb-0"><i class="bi bi-people me-1"></i>Participants (<?= count($participants) ?>)</p>
    </div>
    <?php if (empty($participants)): ?>
        <p class="text-secondary mb-0" style="font-size:.85rem">Aucun participant pour le moment.</p>
    <?php else: ?>
        <div class="d-flex flex-wrap gap-2">
            <?php foreach ($participants as $p): ?>
                <span class="vf-badge <?= $p['role'] === 'organizer' ? 'badge-started' : 'badge-confirmed' ?>"
                      style="font-size:.8rem;padding:4px 12px">
                    <?php if ($p['role'] === 'organizer'): ?>
                        <i class="bi bi-star-fill me-1" style="font-size:.65rem"></i>
                    <?php endif ?>
                    <?= $this->e($p['username']) ?>
                </span>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>

<!-- Knockout rounds -->
<?php if (!empty($knockoutRounds)):
    $roundLabels = ['R16' => 'Seizièmes', 'QF' => 'Quarts de finale', 'SF' => 'Demi-finales', 'F' => 'Finale'];
?>
    <div class="mb-4">
        <p class="vf-section-title mb-3"><i class="bi bi-diagram-3 me-1"></i>Phase éliminatoire</p>
        <?php foreach ($roundLabels as $roundKey => $roundLabel): ?>
            <?php if (!isset($knockoutRounds[$roundKey])) continue; ?>
            <div class="mb-3">
                <p class="vf-section-title mb-2" style="color:#60a5fa"><?= $roundLabel ?></p>
                <div class="row g-2">
                    <?php
                    $matches = $knockoutRounds[$roundKey];
                    // Grouper leg 1 et leg 2 ensemble (par paires)
                    $leg1s = array_filter($matches, fn($m) => $m->getLeg() === '1' || $m->getLeg() === 'single');
                    foreach ($leg1s as $leg1):
                        $leg2 = null;
                        foreach ($matches as $m) {
                            if ($m->getLeg() === '2'
                                && $m->getHomeName() === $leg1->getAwayName()
                                && $m->getAwayName() === $leg1->getHomeName()) {
                                $leg2 = $m;
                                break;
                            }
                        }
                    ?>
                    <div class="col-md-6">
                        <div class="vf-card p-3">
                            <!-- Leg 1 -->
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="fw-semibold text-white" style="font-size:.9rem"><?= $this->e($leg1->getHomeName()) ?></span>
                                <span class="fw-bold mx-2" style="color:var(--vf-green);letter-spacing:2px">
                                    <?= $leg1->getResultHome() !== null ? $leg1->getResultHome() . ' – ' . $leg1->getResultAway() : '? – ?' ?>
                                </span>
                                <span class="fw-semibold text-white" style="font-size:.9rem"><?= $this->e($leg1->getAwayName()) ?></span>
                            </div>
                            <?php if ($leg2): ?>
                            <!-- Leg 2 -->
                            <div class="d-flex align-items-center justify-content-between" style="opacity:.7">
                                <span style="font-size:.82rem;color:#94a3b8"><?= $this->e($leg2->getHomeName()) ?></span>
                                <span class="fw-bold mx-2" style="color:#94a3b8;letter-spacing:2px;font-size:.82rem">
                                    <?= $leg2->getResultHome() !== null ? $leg2->getResultHome() . ' – ' . $leg2->getResultAway() : '? – ?' ?>
                                </span>
                                <span style="font-size:.82rem;color:#94a3b8"><?= $this->e($leg2->getAwayName()) ?></span>
                            </div>
                            <?php endif ?>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="vf-badge badge-<?= $this->e($leg1->getStatut()) ?>" style="font-size:.7rem"><?= $this->e($leg1->getStatut()) ?></span>
                                <a href="/matches/<?= $leg1->getId() ?>" class="text-decoration-none" style="color:var(--vf-green);font-size:.8rem">
                                    Voir <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>

<!-- Groups & Standings -->
<?php if (empty($groups)): ?>
    <div class="vf-card p-5 text-center">
        <i class="bi bi-people display-4 text-secondary mb-3 d-block"></i>
        <p class="text-secondary mb-0">Les groupes n'ont pas encore été générés.</p>
    </div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($groups as $group): ?>
            <div class="col-md-6">
                <div class="vf-card p-4">
                    <p class="vf-section-title mb-3"><?= $this->e($group->getNom()) ?></p>

                    <table class="table vf-table mb-0">
                        <thead>
                            <tr>
                                <th>Joueur</th>
                                <th class="text-center">J</th>
                                <th class="text-center">G</th>
                                <th class="text-center">N</th>
                                <th class="text-center">P</th>
                                <th class="text-center">DB</th>
                                <th class="text-center fw-bold" style="color:#e2e8f0">Pts</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($standings[$group->getId()] ?? [] as $i => $s): ?>
                                <tr>
                                    <td>
                                        <?php if ($i === 0): ?>
                                            <i class="bi bi-star-fill me-1" style="color:var(--vf-green);font-size:.7rem"></i>
                                        <?php endif ?>
                                        <?= $this->e($s->getUsername()) ?>
                                    </td>
                                    <td class="text-center text-secondary"><?= $s->getPlayed() ?></td>
                                    <td class="text-center text-secondary"><?= $s->getWins() ?></td>
                                    <td class="text-center text-secondary"><?= $s->getDraws() ?></td>
                                    <td class="text-center text-secondary"><?= $s->getLosses() ?></td>
                                    <td class="text-center text-secondary"><?= $s->getGoalDiff() >= 0 ? '+' . $s->getGoalDiff() : $s->getGoalDiff() ?></td>
                                    <td class="text-center fw-bold" style="color:var(--vf-green)"><?= $s->getPoints() ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>
