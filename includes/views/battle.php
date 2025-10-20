<div>
    <h1>Battle Arena</h1>
    <p>Choisissez votre créature pour le combat :</p>
    <form action="battle" method="post">
        <select name="creature1" class="form-select mb-3">
            <?php foreach ($params['creature1'] as $creature): ?>
                <option value="<?= $creature['id'] ?>"><?= htmlspecialchars($creature['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <p>Choisissez son adversaire pour le combat :</p>
        <select name="creature2" class="form-select mb-3">
            <?php foreach ($params['creatures'] as $creature): ?>
                <option value="<?= $creature['id'] ?>"><?= htmlspecialchars($creature['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Lancer le combat</button>
    </form>
</div>