<?php
require_once __DIR__ . '/Db.connector.php';

try {
  $db = Db_connector::getConnection();

  // --- Types ---
  $types = ['Dragon', 'Hydre', 'Griffon', 'Minotaure', 'Phoenix'];
  $stmt = $db->prepare("INSERT OR IGNORE INTO type (name) VALUES (:name)");
  foreach ($types as $t) {
    $stmt->execute([':name' => $t]);
  }

  // --- Utilisateurs ---
  $users = [
    [ 'email' => 'admin@example.com', 'password' => password_hash('admin', PASSWORD_DEFAULT), 'pseudo' => 'Admin'],
    [ 'email' => 'user@example.com', 'password' => password_hash('password', PASSWORD_DEFAULT), 'pseudo' => 'User']
  ];
  $stmt = $db->prepare("INSERT OR IGNORE INTO users ( email, password, pseudo) VALUES (:email, :password, :pseudo)");
  foreach ($users as $u) {
    $stmt->execute($u);
  }

  // --- Créatures ---
  $creatures = [
    ['name' => 'Dragon Rouge', 'description' => 'Un dragon majestueux aux écailles rouges', 'type_id' => 1, 'health_score' => 150, 'defense_score' => 50, 'attack_score' => 95, 'heads' => 1],
    ['name' => 'Hydre', 'description' => 'Une créature terrifiante à plusieurs têtes', 'type_id' => 2, 'health_score' => 200, 'defense_score' => 60, 'attack_score' => 88, 'heads' => 7],
    ['name' => 'Griffon', 'description' => 'Un mélange d’aigle et de lion', 'type_id' => 3, 'health_score' => 120, 'defense_score' => 40, 'attack_score' => 75, 'heads' => 1],
    ['name' => 'Minotaure', 'description' => 'Un être mi-homme mi-taureau', 'type_id' => 4, 'health_score' => 180, 'defense_score' => 70, 'attack_score' => 82, 'heads' => 1],
    ['name' => 'Phoenix', 'description' => 'Un oiseau de feu qui renaît de ses cendres', 'type_id' => 5, 'health_score' => 100, 'defense_score' => 30, 'attack_score' => 90, 'heads' => 1]
  ];

  $stmt = $db->prepare("
        INSERT INTO creature (name, description, type_id, health_score, defense_score, attack_score, heads)
        VALUES (:name, :description, :type_id, :health_score, :defense_score, :attack_score, :heads)
    ");

  foreach ($creatures as $c) {
    $stmt->execute($c);
  }

  echo "Données de test insérées avec succès.\n";

} catch (PDOException $e) {
  echo "Erreur : " . $e->getMessage();
}