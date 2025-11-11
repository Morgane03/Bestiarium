<?php
require_once 'C:\wamp64\www\MyDigitalSchool\Bestiarium\includes\database\Db.connector.php';

class APIUserController
{
  private PDO $db;

  public function __construct() {
    $this->db = Db_connector::getConnection();
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }

  /**
   * Summary of addUser
   * @param string $pseudo
   * @param string $email
   * @param string $password
   * @return array{email: string, message: string, password: string, pseudo: string, success: bool|array{message: string, success: bool}}
   */
  public function addUser (string $pseudo, string $email, string $password) : array
  {
    try {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      $stmt = $this->db->prepare("
                INSERT INTO users (pseudo, email, password) 
                VALUES (:pseudo, :email, :password)
            ");
      $stmt->execute([
        ':pseudo' => $pseudo,
        ':email' => $email,
        ':password' => $hashedPassword
      ]);

      return [
        'success' => true,
        'message' => 'Utilisateur ajouté avec succès.',
        'pseudo' => $pseudo,
        'email' => $email
      ];
    } catch (PDOException $e) {

      return ['success' => false, 'message' => 'Erreur lors de l\'ajout de l\'utilisateur.'];
    }
  }

  /**
   * Summary of loginUser
   * Logs in a user by verifying their pseudo and password.
   * @param string $pseudo
   * @param string $password
   * @return array{message: string, success: bool, user_id: string|array{message: string, success: bool}}
   */
  public function loginUser (string $pseudo, string $password)
  {
    try {
      // Prepare the SQL query to fetch the user by pseudo.
      $stmt = $this->db->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
      $stmt->bindParam(':pseudo', $pseudo);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      // Verify if the user exists and if the password is correct.
      if ($user && password_verify($password, $user['password'])) {
        if (session_status() === PHP_SESSION_NONE) {
          session_start();
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['pseudo'] = $user['pseudo'];

        return ['success' => true,
                'message' => 'Utilisateur connecté avec succès.',
                'user_id' => $user['id']];
      } else {
        // Explicitly return on invalid credentials so all code paths return a value.
        return ['success' => false, 'message' => 'Pseudo ou mot de passe incorrect.'];
      }
    } catch (PDOException $e) {
      return ['success' => false, 'message' => 'Erreur lors de la connexion de l\'utilisateur.'];
    }
  }

  /**
   * Summary of logoutUser
   * Logs out the currently logged-in user.
   * @return array{message: string, success: bool}
   */
  public function logoutUser ()
  {
    try {
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }

      // Check if there is a user currently logged in.
      if (!isset($_SESSION['user_id'])) {
        return ['success' => false, 'message' => 'Aucun utilisateur connecté.'];
      }

      // Clear the session and destroy it.
      session_unset();
      session_destroy();

      return ['success' => true, 'message' => 'Utilisateur deconnecté avec succès.'];
    } catch (PDOException $e) {
      return ['success' => false, 'message' => 'Erreur lors de la deconnexion de l\'utilisateur.'];
    }
  }
}