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
   * Retrieves the ID of a given type from the database.
   * If the type exists, it returns the ID; otherwise, returns false.
   *
   * @param mixed $type The name of the type to look for.
   * @return mixed The ID of the type, or false if not found.
   */
  public function getTypeId ($type)
  {
    try {
      $stmt = $this->db->prepare("SELECT id FROM type WHERE name = :name");
      $stmt->bindParam(':name', $type);
      $stmt->execute();
      $typeBdd = $stmt->fetch(PDO::FETCH_ASSOC);

      // Return the ID if the type exists, otherwise false
      return $typeBdd ? $typeBdd['id'] : false;
    } catch (PDOException $e) {
      return "Erreur lors de la récupération du type : " . $e->getMessage();
    }
  }

  /**
   * Creates a new type in the database.
   * @param mixed $type
   * @return bool|string
   */
  public function createType ($type)
  {
    try {
      $stmt = $this->db->prepare("INSERT INTO type (name) VALUES (:name)");
      $stmt->bindParam(':name', $type);
      $stmt->execute();

      return $this->db->lastInsertId(); // Return the ID of the new type
    } catch (PDOException $e) {
      return "Erreur lors de l'ajout du type : " . $e->getMessage();
    }
  }

  /**
   * Retrieves the ID of a type, or creates it if it doesn't exist.
   *
   * @param mixed $type The name of the type.
   * @return mixed The ID of the type, whether it was retrieved or created.
   */
  public function getOrCreateTypeId ($type)
  {
    // Attempt to retrieve the type ID
    $typeId = $this->getTypeId($type);

    // If the type doesn't exist, create it and return the new ID
    if (!$typeId) {
      $typeId = $this->createType($type);
    }

    return $typeId;
  }
}