<?php
require_once('../includes/pollinations/Pollinations.class.php');

class ApiMatchController
{
  private $pdo;
  private $monsterController;

  public function __construct ()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    $db = new Db_connector();
    $this->pdo = $db->GetDbConnection();
    $this->monsterController = new ApiMonsterController();
  }

  /**
   * Retrieve match details and generate the AI prompt.
   *
   * @param array $datas
   * @return string
   */
  private function generateMatchPrompt(array $datas): string
  {
    $prompt = file_get_contents('../includes/pollinations/monster.battle.prompt');

    // Replace the placeholders with the creatures' data
    foreach (['creature1', 'creature2'] as $creaturePrefix) {
      $creature = $datas[$creaturePrefix];
      $prompt = str_replace("{{{$creaturePrefix}_id}}", $creature['id'], $prompt);
      $prompt = str_replace("{{healthScore{$creaturePrefix}}}", $creature['health_score'], $prompt);
      $prompt = str_replace("{{attackScore{$creaturePrefix}}}", $creature['attack_score'], $prompt);
      $prompt = str_replace("{{defenseScore{$creaturePrefix}}}", $creature['defense_score'], $prompt);
    }

    return $prompt;
  }

  /**
   * GetInfoMatch generates the match details prompt for the AI.
   * @param array $datas
   */
  private function getInfoMatch (array $creature1, array $creature2)
  {
    $prompt = $this->generateMatchPrompt([
      'creature1' => $creature1,
      'creature2' => $creature2
    ]);

    return Pollinations::requestIA($prompt);
  }

  /**
   * Validate if creatures data is available.
   *
   * @param array $datas
   * @return bool
   */
  private function validateCreatures(array $datas): bool
  {
    return isset($datas['creature1']) && isset($datas['creature2']);
  }

  /**
   * AddMatch handles adding a new match between two creatures.
   * @param array $datas
   * @return array{matchID: bool|string, message: string, success: bool, winner_id: int|array{message: string, success: bool}}
   */
  function addMatch (array $datas = []) : array
  {
    try {

      if (!$this->validateCreatures($datas)) {
        return ['success' => false, 'message' => 'Les informations sur les créatures sont manquantes.'];
      }

      // Retrieve full information of both creatures by their IDs
      $creature1 = $this->monsterController->getCreature($datas['creature1']['id']);
      $creature2 = $this->monsterController->getCreature($datas['creature2']['id']);

      if (!$creature1 || !$creature2) {
        return ['success' => false, 'message' => 'Une des créatures spécifiées n\'existe pas.'];
      }

      // Get match information from AI
      $infoMatch = $this->getInfoMatch($creature1, $creature2);

      $matchID = $this->add($infoMatch, $datas['creature1']['id'], $datas['creature2']['id']);

      return [
        'success'   => true,
        'message'   => 'Match ajouté avec succès.',
        'matchID'   => $matchID,
        'winner_id' => (int)$infoMatch->winner
      ];

    } catch (PDOException $e) {
      error_log($e->getMessage());
      return ['success' => false, 'message' => 'Une erreur est survenue lors de l\'ajout du match.'];
    }
  }

  /**
   * add the match to the database.
   * @param mixed $infoMatch
   * @param int $creature1_id
   * @param int $creature2_id
   * @return bool|string
   */
  protected function add ($infoMatch, int $creature1_id, int $creature2_id)
  {

    $sql = 'INSERT INTO battle (creature1_id, creature2_id, winner_id) 
                   VALUES (:creature1_id, :creature2_id, :winner_id)';

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':creature1_id', $creature1_id);
    $stmt->bindParam(':creature2_id', $creature2_id);
    $stmt->bindParam(':winner_id', $infoMatch->winner);
    $stmt->execute();

    return $this->pdo->lastInsertId();
  }

  /**
   * showAllMatches retrieves all the matches stored in the database.
   * @return array|array{message: string, success: bool}
   */
  public function showAllMatches () : array
  {
    try {
      // Recovery of fights
      $sql = "SELECT * FROM battle";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute();

      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (empty($results)) {
        return ['success' => true,
                'message' => 'Aucun match trouvé'];
      }

      return $results;
    } catch (PDOException $e) {
      echo "Erreur de connexion à la base de données : " . $e->getMessage();

      return ['success' => false,
              'message' => 'Erreur de connexion à la base de données : ' . $e->getMessage()];
    }
  }
}