<?php 
require_once(__DIR__.'/../Models/Db.php');

class Pairing extends Db {
    private $table = 'pairings';

    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }

    /**
     * goalsテーブルから指定player_idに一致するデータを取得
     *
     * @param integer $id 選手のID
     * @return Array $result 選手のゴールデータ
     */
    public function findById($id = 0):Array {
        $sql = 'SELECT * FROM '.$this->table;
        $sql .= ' WHERE id='.$id;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':player_id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function grabEnemyCountry($id):Array {
      $sql = 'SELECT enemy_country_id FROM pairings';
      $sql .= ' where id = '. $id;
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    public function grabGametime($id):Array {
      $sql = 'SELECT kickoff FROM pairings';
      $sql .= ' where id = '. $id;
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }


}