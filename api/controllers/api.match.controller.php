<?php
require_once('../includes/pollinations/Pollinations.class.php');

class ApiMatchController
{
  private $pdo;

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
   * GetInfoMatch generates the match details prompt for the AI.
   * @param array $datas
   */
  private function getInfoMatch (array $datas = [])
  {
    $prompt = file_get_contents('../includes/pollinations/monster.battle.prompt');

    // Replace placeholders with actual creature data
    $prompt = str_replace('{{creature1_id}}', $datas['creature1']['id'], $prompt);
    $prompt = str_replace('{{healthScore1}}', $datas['creature1']['health_score'], $prompt);
    $prompt = str_replace('{{attackScore1}}', $datas['creature1']['attack_score'], $prompt);
    $prompt = str_replace('{{defenseScore1}}', $datas['creature1']['defense_score'], $prompt);

    $prompt = str_replace('{{creature2_id}}', $datas['creature2']['id'], $prompt);
    $prompt = str_replace('{{healthScore2}}', $datas['creature2']['health_score'], $prompt);
    $prompt = str_replace('{{attackScore2}}', $datas['creature2']['attack_score'], $prompt);
    $prompt = str_replace('{{defenseScore2}}', $datas['creature2']['defense_score'], $prompt);

    return Pollinations::requestIA($prompt);
  }

  /**
   * AddMatch handles adding a new match between two creatures.
   * @param array $datas
   * @return array{matchID: bool|string, message: string, success: bool, winner_id: int|array{message: string, success: bool}}
   */
  function addMatch (array $datas = []) : array
  {
    try {
      // Create an instance of ApiMonsterController to fetch creature data
      $monsterController = new ApiMonsterController();

      if (!isset($datas['creature1']) || !isset($datas['creature2'])) {
        return ['success' => false, 'message' => 'Les informations sur les créatures sont manquantes.'];
      }

      // Retrieve full information of both creatures by their IDs
      $creature1 = $monsterController->getCreature($datas['creature1']['id']);
      $creature2 = $monsterController->getCreature($datas['creature2']['id']);

      if (!$creature1 || !$creature2) {
        return ['success' => false, 'message' => 'Une des créatures spécifiées n\'existe pas.'];
      }

      // Get match information from AI
      $infoMatch = $this->getInfoMatch([
        'creature1' => $creature1,
        'creature2' => $creature2
      ]);

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
      // Récupération des combats
      $sql = "SELECT * FROM battle";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute();

      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (empty($results)) {
        return ['success' => true,
                'message' => 'Aucun match trouvé'];
      }

      return $results; // Retourne touts les combats
    } catch (PDOException $e) {
      echo "Erreur de connexion à la base de données : " . $e->getMessage();

      return ['success' => false,
              'message' => 'Erreur de connexion à la base de données : ' . $e->getMessage()];
    }
  }
}