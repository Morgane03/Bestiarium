<div class="container mx-auto p-5">
    <h1 class="fw-bold">Créer un hybride à partir de <?= htmlspecialchars($params['creature1']['name']) ?></h1>
    <div>
        <form action="addHybrid" method="POST">
            <input type="hidden" name="creature1" value="<?= $params['creature1']['id'] ?>">
            <select name="creature2" id="creature2" class="form-select mb-3">
                <option value="">Sélectionner la deuxième créature</option>
                <?php foreach ($params['creatures'] as $creature): ?>
                    <?php if ($creature['id'] !== $params['creature1']['id']): ?>
                        <option value="<?= $creature['id'] ?>"><?= htmlspecialchars($creature['name']) ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Créer l'hybride</button>
        </form>
    </div>
</div>