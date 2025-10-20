PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "users" (
    id INTEGER PRIMARY KEY,
    "pseudo" TEXT NOT NULL, password TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
,
    email TEXT NOT NULL UNIQUE);
INSERT INTO users VALUES(1,'Test_api','$2y$10$3y7SzwvTiNziAvvtG4PbIOr6f0sEdiUCUbjVPzOhvWvSAaFNj9w3a','2025-10-15 14:58:12','test_bd@gamila.com');
INSERT INTO users VALUES(2,'secondCompte','$2y$10$2hb7Am5inxzC9ELV/BslvOOAxKf3aY2yPls7AsFJczsW9fHmfqV6C','2025-10-16 09:44:05','test2_bd@gamila.com');
CREATE TABLE type(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO type VALUES(5,'ténèbres','2025-10-15 14:41:55');
INSERT INTO type VALUES(6,'feu','2025-10-15 14:46:11');
INSERT INTO type VALUES(7,'eau','2025-10-16 08:08:36');
INSERT INTO type VALUES(8,'vent','2025-10-16 09:45:15');
INSERT INTO type VALUES(9,'Hybride légendaire','2025-10-16 10:26:47');
INSERT INTO type VALUES(10,'Hybride mythologique','2025-10-16 10:35:49');
INSERT INTO type VALUES(11,'terre','2025-10-16 11:58:23');
INSERT INTO type VALUES(12,'Hybride mystico-aérien','2025-10-16 12:17:23');
INSERT INTO type VALUES(13,'Hybride élémentaire','2025-10-16 12:38:29');
CREATE TABLE creature(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    type_id INTEGER NOT NULL,
    heads INTEGER DEFAULT 1,
    image VARCHAR(255),
    health_score INTEGER NOT NULL DEFAULT 0,
    attack_score INTEGER NOT NULL DEFAULT 0,
    defense_score INTEGER NOT NULL DEFAULT 0,
    is_fusion BOOLEAN DEFAULT 0,
    created_by INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (type_id) REFERENCES type(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);
INSERT INTO creature VALUES(17,'Hydroditus','Une créature mystérieuse aux trois têtes, fluide comme l''eau et capable d''adaptabilité étonnante.',7,3,'includes\images\creatures\17.jpg',900,70,80,0,1,'2025-10-16 09:38:38');
INSERT INTO creature VALUES(18,'Hydracerfou','Une bête légendaire à cinq têtes, enflammée et imprévisible.',6,5,'includes\images\creatures\18.jpg',15,8,6,0,2,'2025-10-16 09:44:32');
INSERT INTO creature VALUES(19,'Esprit du Vent','Une créature éthérée qui danse dans les courants d''air, insaisissable et rapide.',8,1,'includes\images\creatures\19.jpg',12,8,4,0,2,'2025-10-16 09:45:15');
INSERT INTO creature VALUES(20,'Phœnix Aérien','Une bête légendaire à cinq têtes, enflammée et imprévisible, fusionnée avec une créature éthérée qui danse dans les courants d''air, insaisissable et rapide.',9,1,'includes\images\creatures\20.jpg',75,85,60,0,2,'2025-10-16 10:26:47');
INSERT INTO creature VALUES(30,'Golem de Terre','Une créature massive faite de roche et de terre, résistante et puissante.',11,1,'includes\images\creatures\30.jpg',15,7,9,0,2,'2025-10-16 12:37:53');
INSERT INTO creature VALUES(32,'Etherea Hydrantès','Une créature hybride élégante combinant la légèreté d''une entité éthérée dansante dans l''air avec la fluidité et la complexité d''une créature mystérieuse à trois têtes. Elle se déplace rapidement, insaisissable, et adapte ses tactiques en un clin d''œil, presque comme si elle respirait l''eau même dans l''air.',12,3,'includes\images\creatures\32.jpg',80,70,50,1,2,'2025-10-16 12:41:33');
CREATE TABLE battle(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    creature1_id INTEGER NOT NULL,
    creature2_id INTEGER NOT NULL,
    winner_id INTEGER,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (creature1_id) REFERENCES creature(id),
    FOREIGN KEY (creature2_id) REFERENCES creature(id),
    FOREIGN KEY (winner_id) REFERENCES creature(id)
);
INSERT INTO battle VALUES(1,18,17,18,'2025-10-16 13:38:48');
CREATE TABLE IF NOT EXISTS "hybrid"(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    parent1_id INTEGER NOT NULL,
    parent2_id INTEGER NOT NULL, `creature_id` INTEGER NOT NULL REFERENCES `creature`(`id`),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent1_id) REFERENCES creature(id),
    FOREIGN KEY (parent2_id) REFERENCES creature(id)
);
INSERT INTO hybrid VALUES(1,19,17,32,'2025-10-16 12:41:36');
INSERT INTO sqlite_sequence VALUES('type',13);
INSERT INTO sqlite_sequence VALUES('creature',32);
INSERT INTO sqlite_sequence VALUES('hybrid',1);
INSERT INTO sqlite_sequence VALUES('battle',3);
COMMIT;
