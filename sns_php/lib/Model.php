<?php

namespace MyApp;

class Model{
  protected $db;

  public function __construct(){
    try{
      $this->db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
    }catch(\PDOException $e){
      echo $e->getMessage();
      exit;
    }
  }

//   protected function db() {
//       try{
//           $_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
//           $_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
//       }catch(\PDOException $e){
//           echo $e->getMessage();
//           exit;
//       }
//       return $_db;
//   }
}
