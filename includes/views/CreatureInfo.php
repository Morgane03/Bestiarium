<div>
    <div class="container mt-5">
        <!-- Titre principal -->
        <div class="row mb-3">
            <div class="col-12 text-center">
                <h1>Détails du Monstre</h1>
            </div>
        </div>

        <!-- Détails du Monstre -->
        <div class="row">
            <div class="col-md-6">
                <!-- Image du Monstre -->
                <img src="<?= htmlspecialchars($params['creature']['image']) ?>" class="img-fluid" alt="Monstre" />
            </div>
            <div class="col-md-6">
                <ul class="list-group">
                    <!-- Nom du Monstre -->
                    <li class="list-group-item"><strong>Nom:</strong> <?= htmlspecialchars($params['creature']['name']) ?></li>
                    <!-- Description -->
                    <li class="list-group-item"><strong>Description:</strong> <?= htmlspecialchars($params['creature']['description']) ?></li>
                    <!-- Type -->
                    <li class="list-group-item"><strong>Type:</strong> <?= htmlspecialchars($params['type']['name']) ?></li>
                    <!-- Points de Vie (Health) -->
                    <li class="list-group-item"><strong>Points de Vie:</strong> <?= htmlspecialchars($params['creature']['health_score']) ?> HP</li>
                    <!-- Attaque -->
                    <li class="list-group-item"><strong>Attaque:</strong> <?= htmlspecialchars($params['creature']['attack_score']) ?></li>
                    <!-- Défense -->
                    <li class="list-group-item"><strong>Défense:</strong> <?= htmlspecialchars($params['creature']['defense_score']) ?></li>
                    <!-- Créé par -->
                    <li class="list-group-item"><strong>Créé par:</strong> </li>
                    <!-- Parents du monstre -->
                  <?php if ($params['creature']['is_fusion']):?>
                    <li class="list-group-item"><strong>Parents:</strong> Monstre A, Monstre B</li>
                  <?php endif; ?>
                </ul>
            </div>
        </div>
</div>