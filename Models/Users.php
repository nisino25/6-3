<?php 
require_once(__DIR__.'/../Models/Db.php');

class Users extends Db {
    private $table = 'users';

    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }

    /**
     * goalsテーブルから指定player_idに一致するデータを取得
     *
     * @param integer $id 選手のID
     * @return Array $result 選手のゴールデータ
     */
    

    public function getRow($email):Array {
      $sql = 'SELECT * FROM users';
      $sql .= " where email = '". $email ."'";
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }



}