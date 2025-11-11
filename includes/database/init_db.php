<?php
require_once __DIR__ . '/Db.connector.php';

try {
  $db = Db_connector::getConnection();

  $schema = <<<SQL
CREATE TABLE IF NOT EXISTS type (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT,
    password TEXT,
    pseudo TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS creature (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    description TEXT,
    type_id INTEGER,
    image TEXT,
    health_score INTEGER NOT NULL,
    attack_score INTEGER NOT NULL,
    defense_score INTEGER NOT NULL,
    heads INTEGER DEFAULT 1,
    hybrid_id INTEGER,
    is_fusion BOOLEAN DEFAULT 0,
    created_by INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hybrid_id) REFERENCES hybrid(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (type_id) REFERENCES types(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS hybrid (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    parent1_id INTEGER NOT NULL,
    parent2_id INTEGER NOT NULL,
    creature_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent1_id) REFERENCES creature(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (parent2_id) REFERENCES creature(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (creature_id) REFERENCES creature(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS battle (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    creature1_id INTEGER,
    creature2_id INTEGER,
    winner_id INTEGER,
    played_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (creature1_id) REFERENCES creature(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (creature2_id) REFERENCES creature(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (winner_id) REFERENCES creature(id) ON DELETE SET NULL ON UPDATE CASCADE
);
SQL;

  $db->exec($schema);
  echo "Base de données initialisée avec succès.\n";

} catch (PDOException $e) {
  echo "Erreur lors de la création de la base : " . $e->getMessage();
}