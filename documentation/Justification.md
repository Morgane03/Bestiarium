### Justification du choix de SQLite

#### 1. Facilité d’intégration
SQLite est un système de gestion de une base de données légère et embarquée.

À la différence de MySQL ou PostgreSQL, SQLite ne demande aucune configuration de serveur externe, les informations étant conservées dans un simple fichier .sqlite ou .db.

#### 2. Idéal pour ce projet 
Le projet « Bestiarium » ne nécessite pas de gérer une grande quantité de données. L'exigence primordiale est la simplicité d'utilisation et l'accès rapide aux informations.

SQLite est donc parfaitement adapté.

#### 3. Aucune maintenance / configuration
Il n'est pas nécessaire de s'occuper d'un utilisateur, d'un mot de passe ou d'un serveur SQL.

Tout est regroupé dans un unique document, ce qui simplifie :
- la conservation du projet,
- La gestion de versions avec Git
  
### Justification de l’architecture orientée objet

#### 1. Réutilisation du code (principe DRY – Don’t Repeat Yourself)
La classe ApiHybridController hérite de ApiMonsterController, ce qui permet de réutiliser toutes les méthodes déjà existantes pour la gestion de base des créature.
Cela évite de réécrire du code identique pour les hybrides, qui partagent la plupart des comportements des créatures "normales"

#### 2. Encapsulation et séparation des responsabilités
Chaque classe a un rôle précis :

- ApiMonsterController gère la création et la manipulation des créatures classiques.
- ApiHybridController étend ce comportement pour gérer la fusion de deux créatures existantes (avec ajout en base, génération IA et liaison parentale).

Cela permet de séparer clairement les responsabilités tout en gardant une logique commune de gestion des entités.

#### 3. Lisibilité et maintenabilité du code
Cette organisation rend le code :
- plus lisible pour les développeurs,
- plus modulaire,
- et plus simple à tester

#### 4. Structure orientée objet multi-contrôleurs
L’application repose sur une architecture orientée objet qui favorise la modularité et la réutilisation du code.
Chaque contrôleur encapsule ainsi la logique métier qui lui est propre, respectant le principe de responsabilité unique.

### Justification de l’utilisation de PDO
L’application utilise PDO (PHP Data Objects) comme interface d’accès à la base de données. PDO améliore la portabilité du projet.
De plus, l’utilisation de requêtes préparées avec prepare() et bindParam() garantit une protection, renforçant la sécurité des interactions avec la base.