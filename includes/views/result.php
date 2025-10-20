<div>
    <h2>Résultat du combat</h2>
    <div>
        <div class="col-md-4">
            <div class="card">
                <?php if ($params['creature1']['id'] === $params['winner_id']): ?>
                    <span class="badge bg-secondary position-absolute m-3">Vainqueur</span>
                <?php endif; ?>
                <img src="<?= $params['creature1']['image'] ?>" class="card-img-top" alt="" width="50px">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($params['creature1']['name']) ?></h5>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="col-md-4">
            <div class="card">
                <?php if ($params['creature2']['id'] === $params['winner_id']): ?>
                    <span class="badge bg-secondary position-absolute m-3">Vainqueur</span>
                <?php endif; ?>
                <img src="<?= $params['creature2']['image'] ?>" class="card-img-top" alt="" width="50px">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($params['creature2']['name']) ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>