<div class="container mx-auto p-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Liste de vos créatures invoquée</h1>
    </div>
    <div class="row">
        <?php if (count($params['creatures']) > 0):
            foreach ($params['creatures'] as $creature): ?>
                <div class="col-md-4">
                    <div class="card">
                        <?php if ($creature['is_fusion'] === 1): ?>
                            <span class="badge bg-secondary position-absolute m-3">Hybride</span>
                        <?php endif; ?>
                        <img src="<?= $creature['image'] ?>" class="card-img-top" alt="" width="50px">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($creature['name']) ?></h5>
                            <a href="showCreatureInfo&creature_id=<?= $creature['id'] ?>" class="btn btn-primary">Voir les
                                informations</a>
                            <a href="showAddHybrid&creature1=<?= $creature['id'] ?>"
                                class="btn btn-primary">Créer un hybrid</a>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <p class="text-center alert alert-secondary">Aucune créature trouvée.</p>
        <?php endif; ?>
        <div>
            <a href="showAddCreature" class="btn btn-success">Créer une nouvelle créature</a>
        </div>
    </div>
</div>