<?php
session_start();
require_once 'includes\controllers\user.controller.php';

$userController = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        // Traitement de l'inscription
        $pseudo = $_POST['pseudo'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $result = $userController->addUser($pseudo, $email, $password);
        // La méthode addUser fait la redirection si succès
        if (isset($result['success']) && !$result['success']) {
            $error = $result['message'];
            // Afficher erreur ou rediriger avec message
        }

    } elseif (isset($_POST['login'])) {
        // Traitement de la connexion
        $pseudo = $_POST['pseudo'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($userController->loginUser($pseudo, $password)) {
                        
            header("Location: ?page=user");

            exit;
        } else {
            $error = "Identifiant ou mot de passe incorrect.";
            // Afficher erreur dans la vue login
        }
    }
}
function requireLogin()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        header("Location: /index.php?page=login");
        exit;
    }
}