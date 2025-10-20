<?php
require_once 'C:\wamp64\www\MyDigitalSchool\Bestiarium\includes\database\Db.connector.php';
class APIUserController
{
    private $db;

    public function __construct()
    {
        $connector = new Db_connector();
        $this->db = $connector->GetDbConnection();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function addUser(string $pseudo, string $email, string $password): array
    {
        try {
            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Préparation de la requête
            $stmt = $this->db->prepare("INSERT INTO users (pseudo, email, password) 
            VALUES (:pseudo, :email, :password)");
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

             return ['success' => true, 'message' => 'Utilisateur ajouté avec succès.'];
        } catch (PDOException $e) {
            // Pour le développement, sinon en prod, log l'erreur proprement
            return ['success' => false, 'message' => 'Erreur lors de l\'ajout de l\'utilisateur.'];
        }
    }

    public function loginUser(string $pseudo, string $password)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['pseudo'] = $user['pseudo'];

                $monsterController = new MonsterController();
                $creatures = $monsterController->getCreatures($_SESSION['user_id']);
                
                return renderPage('user', ['creatures' => $creatures]);
            }
            return renderPage('login');
        } catch (PDOException $e) {
            return renderPage('login');
        }
    }

    public function logoutUser()
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            session_unset();
            session_destroy();
            return renderPage('login');
        } catch (PDOException $e) {
            return renderPage('user');
        }
    }
}