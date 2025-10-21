<?php
require_once('../includes/pollinations/Pollinations.class.php');
require_once('../api/controllers/api.type.controller.php');

class ApiHybridController extends ApiMonsterController
{
  public function __construct ()
  {
    parent::__construct();
  }

  function addHybrid (array $datas = [])
  {
    try {
      //$monsterController = new MonsterController();
      $creature1 = $this->getCreature($datas['creature1']);
      $creature2 = $this->getCreature($datas['creature2']);

      if ($creature1 && $creature2) {
        // Logique pour créer l'hybride
        $infoCreature = $this->getInfoHybrid($creature1['description'], $creature2['description']);

        $typeController = new APITypeController();

        // Récupération ou création de l'ID du type
        $type_id = $typeController->getOrCreateTypeId($infoCreature->type);

        $creatureID = $this->add($infoCreature, $type_id, (int)$infoCreature->tete, true);
        $this->updateHybrid($creatureID);

        $image = $this->getImage($creatureID, $infoCreature->description);
        $this->updateImage($creatureID, $image);

        $this->addSql($creature1['id'], $creature2['id'], $creatureID);

        $creatures = $this->getCreatures($datas['user_id']);
        $creature = $this->getCreature($creatureID);

        //renderPage( 'user', ['creatures' => $creatures]);
        return ['success'       => true,
                'message'       => 'Hybride ajoutée avec succes',
                'creature_id'   => $creatureID,
                'name'           => $creature['name'],
                'image'         => $creature['image'],
                'description'   => $creature['description'],
                'heads'         => $creature['heads'],
                'type'          => $creature['type'],
                'health_score'  => $creature['health_score'],
                'attack_score'  => $creature['attack_score'],
                'defense_score' => $creature['defense_score'],
                'is_fusion'     => $creature['is_fusion'],
                'user_id'       => $datas['user_id'],
        ];
      }
    } catch (PDOException $e) {
      return ['success' => false, 'message' => 'Erreur lors de la creation de l\'hybride :' . $e->getMessage()];
    }
  }

  private function getInfoHybrid (string $descriptionP1, string $descriptionP2)
  {
    $prompt = file_get_contents('C:\wamp64\www\MyDigitalSchool\Bestiarium\includes\pollinations\monster.hybrid.prompt');

    $prompt = str_replace('{{descriptionP1}}', $descriptionP1, $prompt);
    $prompt = str_replace('{{descriptionP2}}', $descriptionP2, $prompt);

    return Pollinations::requestIA($prompt);
  }

  private function addSql (int $creature1, int $creature2, int $hybridId)
  {
    try {
      $stmt = $this->pdo->prepare('INSERT INTO hybrid (parent1_id, parent2_id, creature_id) 
                                            VALUES (:parent1_id, :parent2_id, :creature_id)');
      $stmt->bindParam(':parent1_id', $creature1);
      $stmt->bindParam(':parent2_id', $creature2);
      $stmt->bindParam(':creature_id', $hybridId);
      $stmt->execute();
    } catch (PDOException $e) {
      echo "Erreur lors de l'ajout de l'hybride : " . $e->getMessage();
    }
  }
}