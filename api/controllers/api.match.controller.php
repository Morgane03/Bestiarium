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

  private function getInfoMatch (array $datas = [])
  {
    $prompt = file_get_contents('../includes/pollinations/monster.battle.prompt');

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

  function addMatch (array $datas = []) : array
  {
    try {
      $monsterController = new ApiMonsterController();

      if (!isset($datas['creature1']) || !isset($datas['creature2'])) {
        return ['success' => false, 'message' => 'Les informations sur les créatures sont manquantes.'];
      }

      // Récupérer les informations complètes sur les créatures avec les ID fournis
      $creature1 = $monsterController->getCreature($datas['creature1']['id']);
      $creature2 = $monsterController->getCreature($datas['creature2']['id']);

      if (!$creature1 || !$creature2) {
        return ['success' => false, 'message' => 'Une des créatures spécifiées n\'existe pas.'];
      }
      // Utilisation de ces informations dans la suite
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
      return "Erreur lors de l'ajout de la créature : " . $e->getMessage();
    }
  }

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
}