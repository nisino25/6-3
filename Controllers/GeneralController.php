<?php
// require_once(__DIR__. '/../Models/Player.php');
// require_once(__DIR__. '/../Models/Goal.php');
// require_once(__DIR__. '/../Models/Pairing.php');

class GeneralController {
  // private $request;   // リクエストパラメータ(GET,POST)// private $Player;
  // private $Player; 
  // private $Goal;
  // private $Pairing; 

  // public function __construct(){
  //   $this->request['get'] = $_GET; 
  //   $this->request['post'] = $_POST; 

  //   $this->Player = new Player();

  //   // 別モデルと連携
  //   $dbh = $this->Player->get_db_handler();
  //   $this->Goal = new Goal($dbh);

  //   // 別モデルと連携
  //   // $dbh = $this->Pairing->get_db_handler();
  //   $this->Pairing = new Pairing($dbh);

  // }

  public function checking(){
    if(!isset($_SERVER['HTTP_REFERER'])){
      header("Location: ./index.php");
      exit;
    }
  }

  public function goBack(){
    header("Location: ./index.php");
    die();
  }






  
}