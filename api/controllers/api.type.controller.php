<?php
require_once 'C:\wamp64\www\MyDigitalSchool\Bestiarium\includes\database\Db.connector.php';
class APIUserController
{
    private $db;

    public function __construct()
    {
        $connector = new Db_connector();
        $this->db = $connector->GetDbConnection();
    }

  public function getOrCreateTypeId($type)
  {
    try {
      // Recherche du type dans la base de données
      $stmt = $this->pdo->prepare("SELECT * FROM type WHERE name = :name");
      $stmt->bindParam(':name', $type);
      $stmt->execute();
      $typeBdd = $stmt->fetch(PDO::FETCH_ASSOC);

      if (empty($typeBdd)) {
        // Si le type n'existe pas, on l'ajoute
        $stmt = $this->pdo->prepare("INSERT INTO type (name) VALUES (:name)");
        $stmt->bindParam(':name', $type);
        $stmt->execute();
        return $this->pdo->lastInsertId(); // Retourne l'ID du nouveau type
      } else {
        // Si le type existe déjà, on retourne son ID
        return $typeBdd['id'];
      }
    } catch (PDOException $e) {
      return "Erreur lors de l'accès ou de l'ajout du type : " . $e->getMessage();
    }
  }

  public function getType(int $typeId){
    try {
      // Recherche du type dans la base de données
      $stmt = $this->pdo->prepare("SELECT * FROM type WHERE id = :id");
      $stmt->bindParam(':id', $typeId);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e) {
      return "Erreur lors de l'accès ou de la recherche du type : " . $e->getMessage();
    }
  }
}