<?php
class Db_connector{
    private $db;

    public function __construct(){
       $this->db = new PDO('sqlite:C:\wamp64\www\MyDigitalSchool\Bestiarium\includes\database\Bestiarium.db');
    }

    public function GetDbConnection(){
        return $this->db;
    }
}