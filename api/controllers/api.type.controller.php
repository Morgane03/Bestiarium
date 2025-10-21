<?php
require_once 'C:\wamp64\www\MyDigitalSchool\Bestiarium\includes\database\Db.connector.php';

class APITypeController
{
  private $db;

  public function __construct ()
  {
    $connector = new Db_connector();
    $this->db = $connector->GetDbConnection();
  }
    
  /**
   * Summary of getTypeId
   * @param mixed $type
   */
  public function getTypeId ($type)
  {
    try {
      $stmt = $this->db->prepare("SELECT id FROM type WHERE name = :name");
      $stmt->bindParam(':name', $type);
      $stmt->execute();
      $typeBdd = $stmt->fetch(PDO::FETCH_ASSOC);

      // Retourne l'ID si le type existe, sinon false
      return $typeBdd ? $typeBdd['id'] : false;
    } catch (PDOException $e) {
      return "Erreur lors de la récupération du type : " . $e->getMessage();
    }
  }

  /**
   * Summary of createType
   * @param mixed $type
   * @return bool|string
   */
  public function createType ($type)
  {
    try {
      $stmt = $this->db->prepare("INSERT INTO type (name) VALUES (:name)");
      $stmt->bindParam(':name', $type);
      $stmt->execute();

      return $this->db->lastInsertId(); // Retourne l'ID du nouveau type
    } catch (PDOException $e) {
      return "Erreur lors de l'ajout du type : " . $e->getMessage();
    }
  }

  /**
   * Summary of getOrCreateTypeId
   * @param mixed $type
   * @return mixed
   */
  public function getOrCreateTypeId ($type)
  {
    // On tente de récupérer le type
    $typeId = $this->getTypeId($type);

    // Si le type n'existe pas, on le crée et retourne son ID
    if (!$typeId) {
      $typeId = $this->createType($type);
    }

    return $typeId;
  }
}