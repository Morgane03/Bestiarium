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

  /**
   * Retrieves a list of creatures from the database.
   * If a userId is provided, only creatures created by that user are returned.
   * @param mixed $userId
   * @return array|array{message: string, success: bool}
   */
  public function getCreatures (?int $userId = null) : array
  {
    try {
      // Fetch creatures from the database
      $sql = "SELECT * FROM creature";
      if (is_null($userId)) {
        return ['success' => false,
                'message' => 'Utilisateur non connecté'];
      }
      $sql .= " WHERE created_by = :user_id";

      $stmt = $this->pdo->prepare($sql);
      if (!is_null($userId)) {
        $stmt->bindParam(':user_id', $userId);
      }
      $stmt->execute();

      // Returns all creatures as an associative array
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return ['success' => false,
              'message' => 'Erreur de connexion à la base de données :' . $e->getMessage()];
    }
  }

  /**
   * Adds a new creature to the database.
   * @param array $datas
   * @return array{attack_score: mixed, creature_id: mixed, defense_score: mixed, description: mixed, heads: mixed, health_score: mixed, image: string, message: string, name: mixed, success: bool, type: mixed, user_id: mixed|array{message: string, success: bool}}
   */
  function addCreature (array $datas = []) : array
  {
    try {
      // Verify if the session is started
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }

      if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
      } else {
        return ['success' => false,
                'message' => 'Utilisateur non connecté'];
      }

      $infoCreature = $this->getInfoCreature($datas);

      $typeController = new APITypeController();

      // Retrieve or create the type ID
      $type_id = $typeController->getOrCreateTypeId($infoCreature->type);

      // Add the creature and get its ID
      $creatureID = $this->add($infoCreature, $type_id, $datas['heads'] ?? 1, $user_id);

      // Generate an image for the creature based on its description
      $image = $this->getImage($creatureID, $infoCreature->description);
      $this->updateImage($creatureID, $image);

      return ['success'       => true,
              'message'       => 'Creature ajoutée avec succes',
              'creature_id'   => $creatureID,
              'name'          => $infoCreature->nom,
              'image'         => $image,
              'description'   => $infoCreature->description,
              'heads'         => $datas['heads'],
              'type'          => $infoCreature->type,
              'health_score'  => $infoCreature->score->sante,
              'attack_score'  => $infoCreature->score->attaque,
              'defense_score' => $infoCreature->score->defense,
              'user_id'       => $user_id,
      ];
    } catch (PDOException $e) {
      return ['success' => false,
              'message' => 'Erreur lors de l\'ajout de la créature :' . $e->getMessage()];
    }
  }

  /**
   * Generates the creature's description using a prompt template and AI.
   * @param array $datas
   */
  private function getInfoCreature (array $datas = [])
  {
    // Read the prompt template for generating the description
    $prompt = file_get_contents('C:\wamp64\www\MyDigitalSchool\Bestiarium\includes\pollinations\monster.description.prompt');

    $prompt = str_replace('{{heads}}', $datas['heads'], $prompt);
    $prompt = str_replace('{{type}}', $datas['type'], $prompt);

    // Call the AI to generate the description
    return Pollinations::requestIA($prompt);
  }

  /**
   * Retrieves an image for the creature using its description.
   * @param int $creature_id
   * @param string $description
   * @return string
   */
  protected function getImage (int $creature_id, string $description = "") : string
  {
    // Define the path to save the image
    $destination = 'C:\wamp64\www\MyDigitalSchool\Bestiarium\includes\images\creatures\\' . $creature_id . '.jpg';
    $image = Pollinations::requestIA($description, false);
    file_put_contents($destination, $image);

    // Return the path to the image
    return 'includes\images\creatures\\' . $creature_id . '.jpg';
  }

  /**
   * Updates the image path of a creature in the database.
   * @param int $creature_id
   * @param string $image
   * @return void
   */
  protected function updateImage (int $creature_id, string $image = "")
  {
    $stmt = $this->pdo->prepare("UPDATE creature SET image = :image WHERE id = :id");
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':id', $creature_id);
    $stmt->execute();
  }

  /**
   * Checks if a creature with the same characteristics already exists in the database.
   * @param mixed $infoCreature
   * @param int $type_id
   * @param int $heads
   * @param int $userId
   */
  protected function checkCreatureExists ($infoCreature, int $type_id, int $heads, int $userId)
  {
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

    // Return the creature if found, otherwise null
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Adds a new creature to the database.
   * @param mixed $infoCreature
   * @param int $type_id
   * @param int $heads
   * @param int $userId
   * @param bool $isHybrid
   */
  protected function add ($infoCreature, int $type_id, int $heads, int $userId)
  {
    $creatureBdd = $this->checkCreatureExists($infoCreature, $type_id, $heads, $userId);

    // If the creature doesn't exist, add it to the database
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

      // Return the ID of the new creature
      return $this->pdo->lastInsertId();
    }

    return $creatureBdd['id'];
  }

  /**
   * Retrieves a creature's data from the database by its ID.
   *
   * @param int $id The ID of the creature to retrieve.
   * @return mixed The creature's data as an associative array, or null if not found.
   */
  function getCreature (int $id)
  {
    try {
      // Retrieve creature by ID
      $sql = "SELECT * FROM creature WHERE id = :id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':id', $id);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {

      return null;
    }
  }

  /**
   * Updates the creature to mark it as a hybrid (fusion).
   *
   * @param int $creature_id The ID of the creature to update.
   * @return void
   */
  protected function updateHybrid (int $creature_id)
  {
    $stmt = $this->pdo->prepare("UPDATE creature SET is_fusion = 1 WHERE id = :id");
    $stmt->bindParam(':id', $creature_id);
    $stmt->execute();
  }
}