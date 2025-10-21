<?php
require_once('../includes/pollinations/Pollinations.class.php');
require_once('../api/controllers/api.type.controller.php');

class ApiMonsterController
{
  protected $pdo;

  public function __construct ()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    $db = new Db_connector();

    // Connexion à la base de donnée
    $this->pdo = $db->GetDbConnection();
  }

  // Fonction pour récupérer les créatures depuis la base de données SQLite
  public function getCreatures (?int $userId = null) : array
  {
    try {
      // Récupération des créatures
      $sql = "SELECT * FROM creature";
      if (!is_null($userId)) {
        $sql .= " WHERE created_by = :user_id";
      }
      $stmt = $this->pdo->prepare($sql);
      if (!is_null($userId)) {
        $stmt->bindParam(':user_id', $userId);
      }
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne toutes les créatures sous forme de tableau
    } catch (PDOException $e) {
      echo "Erreur de connexion à la base de données : " . $e->getMessage();

      return []; // Retourne un tableau vide en cas d'erreur
    }
  }

  function addCreature (array $datas = []) : array
  {
    try {
      // Vérification si la session est bien démarrée
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }

      // Determine user id: prefer provided data (from client) otherwise use session
      $user_id = $datas['user_id'] ?? $_SESSION['user_id'] ?? null;

      if (is_null($user_id)) {
        return ['success' => false, 'message' => 'Utilisateur non connecté'];
      }

      $infoCreature = $this->getInfoCreature($datas);

      $typeController = new APITypeController();

      // Récupération ou création de l'ID du type
      $type_id = $typeController->getOrCreateTypeId($infoCreature->type);

      $creatureID = $this->add($infoCreature, $type_id, $datas['heads'] ?? 1, $user_id);

      $image = $this->getImage($creatureID, $infoCreature->description);
      $this->updateImage($creatureID, $image);

      return ['success'        => true,
              'message'        => 'Creature ajoutée avec succes',
              'creature_id'    => $creatureID,
              'name'           => $infoCreature->nom,
              'image'          => $image,
              'description'    => $infoCreature->description,
              'heads'          => $datas['heads'],
              'type'           => $infoCreature->type,
              ':health_score'  => $infoCreature->score->sante,
              ':attack_score'  => $infoCreature->score->attaque,
              ':defense_score' => $infoCreature->score->defense,
              'user_id'        => $user_id,
      ];
    } catch (PDOException $e) {
      return ['success' => false, 'message' => 'Erreur lors de l\'ajout de la créature :' . $e->getMessage()];
    }
  }

  private function getInfoCreature (array $datas = [])
  {
    $prompt = file_get_contents('C:\wamp64\www\MyDigitalSchool\Bestiarium\includes\pollinations\monster.description.prompt');

    $prompt = str_replace('{{heads}}', $datas['heads'], $prompt);
    $prompt = str_replace('{{type}}', $datas['type'], $prompt);

    return Pollinations::requestIA($prompt);
  }

  protected function getImage (int $creature_id, string $description = "") : string
  {
    $destination = 'C:\wamp64\www\MyDigitalSchool\Bestiarium\includes\images\creatures\\' . $creature_id . '.jpg';
    $image = Pollinations::requestIA($description, false);
    //$image = file_get_contents(Pollinations::requestIA($description, false));
    file_put_contents($destination, $image);


    return 'includes\images\creatures\\' . $creature_id . '.jpg';
  }

  protected function updateImage (int $creature_id, string $image = "")
  {
    $stmt = $this->pdo->prepare("UPDATE creature SET image = :image WHERE id = :id");
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':id', $creature_id);
    $stmt->execute();
  }

  protected function add ($infoCreature, int $type_id, int $heads, int $userId, bool $isHybrid = false)
  {
    // Code pour ajouter une créature
    $stmt = $this->pdo->prepare("SELECT * FROM creature WHERE name = :name AND 
                                        description = :description AND type_id = :type_id AND 
                                        heads = :heads AND health_score = :health_score AND 
                                        attack_score = :attack_score AND defense_score = :defense_score 
                                        AND created_by = :userId");
    $stmt->bindParam(':name', $infoCreature->nom);
    $stmt->bindParam(':description', $infoCreature->description);
    $stmt->bindParam(':type_id', $type_id);
    $stmt->bindParam(':heads', $heads);
    $stmt->bindParam(':health_score', $infoCreature->score->sante);
    $stmt->bindParam(':attack_score', $infoCreature->score->attaque);
    $stmt->bindParam(':defense_score', $infoCreature->score->defense);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $creatureBdd = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($creatureBdd)) {
      $sql = 'INSERT INTO creature (name, description, type_id, heads, 
                                            health_score, attack_score, defense_score , created_by) 
                                            VALUES (:name, :description, :type_id, :heads, :health_score, 
                                            :attack_score, :defense_score, :userId)';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':name', $infoCreature->nom);
      $stmt->bindParam(':description', $infoCreature->description);
      $stmt->bindParam(':type_id', $type_id);
      $stmt->bindParam(':heads', $heads);
      $stmt->bindParam(':health_score', $infoCreature->score->sante);
      $stmt->bindParam(':attack_score', $infoCreature->score->attaque);
      $stmt->bindParam(':defense_score', $infoCreature->score->defense);
      $stmt->bindParam(':userId', $userId);
      $stmt->execute();

      return $this->pdo->lastInsertId();
    }

    // echo "La créature existe déjà dans la base de données.";
    return $creatureBdd['id'];
  }

  function getCreature (int $id)
  {
    try {
      // Récupération des créatures
      $sql = "SELECT * FROM creature WHERE id = :id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':id', $id);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      //echo "Erreur de connexion à la base de données : " . $e->getMessage();

      return null;
    }
  }

  protected function updateHybrid (int $creature_id)
  {
    $stmt = $this->pdo->prepare("UPDATE creature SET is_fusion = 1 WHERE id = :id");
    $stmt->bindParam(':id', $creature_id);
    $stmt->execute();
  }
}