<?php
// S'assure que $viewFile est bien défini avant inclusion
if (!isset($viewFile)) {
    die('Erreur : fichier de vue non défini.');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bestiarium</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <header class="bg-lightgreen p-3 mb-4">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Bestiarium</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="home">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout">Deconnexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="showRegister">Inscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="showLogin">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="showUserPage">Mon compte</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Actions
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="showAddCreature">Créer une créature</a></li>
                                    <li><a class="dropdown-item" href="#">Fusionner une créature</a></li>
                                    <li><a class="dropdown-item" href="showBattle">Faire un combat</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <?php include $viewFile; ?>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>