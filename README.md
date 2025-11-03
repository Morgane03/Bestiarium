# API Bestinarium
Bienvenue dans la documentation de l'API Bestinarium. Cette API permet de gérer des utilisateurs, des créatures, et de réaliser des combats entre créatures. Vous pouvez créer des utilisateurs, ajouter des créatures, afficher leurs informations, créer des hybrides, et organiser des matchs entre créatures.

## Prérequis
Avant de commencer, assurez-vous que votre environnement de développement possède les éléments suivants :

- **PHP 7.4+** : L'API est écrite en PHP natif, assurez-vous que PHP est installé et à jour sur votre machine.
- **SQLite** : La base de données utilisée est SQLite, qui ne nécessite pas de serveur de base de données externe.
- **Serveur Web** : Un serveur comme Apache ou Nginx avec PHP activé est nécessaire pour exécuter l'API. Vous pouvez aussi utiliser le serveur interne de PHP pour tester localement.
- **Composer** : Utilisé pour gérer les dépendances PHP, si nécessaire.

## Installation

### 1. Cloner le projet
Clonez le dépôt contenant le code de l'API :

```bash
git clone https://github.com/Morgane03/Bestiarium.git
cd Bestiarium
```

### 2 Installer les dépendances PHP (si applicable)
Si vous utilisez des dépendances externes, vous pouvez installer Composer et les gérer avec la commande suivante :

```bash
composer install
```

### La base de données SQLite
L'API utilise SQLite comme base de données. Créez le fichier de base de données SQLite dans le répertoire database/ si ce n'est pas déjà fait :

### a. Installation de SQLite
Si vous ne l'avez pas encore fait, vous devrez installer SQLite. Voici comment procéder en fonction de votre système d'exploitation.
Sur Ubuntu/Debian
```bash
sudo apt update
sudo apt install sqlite3
```
Sur macOS

SQLite devrait être installé par défaut, mais si ce n'est pas le cas, vous pouvez utiliser brew pour l'installer :
```bash
brew install sqlite
```
Sur Windows

Vous pouvez télécharger SQLite directement depuis le site officiel. Téléchargez la version précompilée de SQLite pour Windows (le fichier .zip). Décompressez-le et ajoutez le dossier contenant sqlite3.exe à votre variable d'environnement PATH.

### Configurer la base de donnée    
```bash
touch includes/database/Bestiarium.db
```
Aucune configuration supplémentaire n'est nécessaire pour SQLite. Vous pouvez utiliser des scripts ou des migrations pour peupler la base de données si nécessaire.

### 4. Configuration du fichier config.php
Configurez les paramètres de l'API, notamment le chemin vers la base de données SQLite et l'API OpenAI Polynesia. Exemple :

```php
<?php
// Configuration de la base de données SQLite
define('DB_PATH', 'includes/database/Bestiarium.db');

// Clé API Polynesia
define('POLYNESIA_API_URL', 'https://text.pollinations.ai/');
define('POLYNESIA_API_URL', 'https://image.pollinations.ai/prompt/');

// Autres paramètres
define('BASE_URL', 'http://localhost:8000');
```

### 5. Lancer l'API
L'API peut être lancée via un serveur PHP intégré pour les tests locaux :

```bash
php -S localhost:8000
```

L'API sera alors disponible à l'adresse suivante : http://localhost:8000

## Utilisation
L'API expose plusieurs endpoints pour gérer les utilisateurs, les créatures, et les combats. Voici une liste des principaux endpoints disponibles :

### 1. Créer un utilisateur
Description : Crée un nouvel utilisateur dans la base de données.

Exemple de requête :

```json
{
  "pseudo": "Jean123",
  "email": "jean@example.com",
  "password": "MotDePasseSecret"
}
```

### 2. Connexion d'un utilisateur
Description : Permet à un utilisateur de se connecter.

Exemple de requête :
```json
{
  "pseudo": "Jean123",
  "password": "MotDePasseSecret"
}
```

### 3. Ajouter une créature
Description : Ajoute une nouvelle créature dans la base de données.

Exemple de requête :
```json
{
  "type": "Dragon",
  "heads": 1
}
```

### 4. Créer un hybride
Description : Crée une créature hybride à partir de deux créatures existantes.

Exemple de requête :
```json
{
  "creature1_id": 101,
  "creature2_id": 102
}
```

### 5. Ajouter un match de combat entre deux créatures
Description : Crée un match entre deux créatures et détermine le vainqueur.

Exemple de requête :
```json
{
  "creature1": {
    "id": 101
  },
  "creature2": {
    "id": 102
  }
}
```

## Accès

### Serveur
Une fois l'API lancée, vous pouvez y accéder à l'adresse suivante :

```ardunio
http://localhost:8000
```

### Format de réponse
Les réponses de l'API sont généralement en format JSON et contiennent des informations sur l'état de la requête, ainsi que des données spécifiques selon l'endpoint utilisé.

## Tester l'API avec Postman
### 1. Télécharger et installer Postman
Si vous n'avez pas encore installé Postman, vous pouvez le télécharger depuis le site officiel de Postman.

### 2. Importer la Collection Postman
La collection Postman pour tester l'API **Bestinarium** est incluse dans ce dépôt. Vous pouvez l'importer directement dans Postman pour commencer à tester les différents endpoints.

#### Étapes pour importer la collection dans Postman :
1. Clonez ou téléchargez ce dépôt Git sur votre machine locale.
2. Ouvrez Postman.
3. Cliquez sur **"Import"** en haut à gauche dans l'interface de Postman.
4. Sélectionnez **"File"** et importez le fichier **`Bestinarium.postman_collection.json`** que vous trouverez à la racine du dépôt.
5. La collection sera alors ajoutée à votre espace de travail Postman.

### 3. **Tester l'API**
Une fois la collection importée, vous pouvez tester les différents endpoints de l'API en sélectionnant simplement les requêtes dans Postman et en cliquant sur **"Send"**.

