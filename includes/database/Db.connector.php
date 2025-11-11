<?php
class Db_connector{
  private static $db;

//    public function __construct(){
//       $this->db = new PDO('sqlite:C:\wamp64\www\MyDigitalSchool\Bestiarium\includes\database\Bestiarium.db');
//    }
//
//    public static function GetDbConnection(){
//        return self::$db;
//    }

  public static function getConnection() {
    if (!self::$db) {
      $dbPath = __DIR__ . '/Bestiarium.db';
      self::$db = new PDO('sqlite:C:\wamp64\www\MyDigitalSchool\Bestiarium\includes\database\Bestiarium.db');
      self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return self::$db;
  }
}