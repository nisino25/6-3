<?php 
// require_once(ROOT_PATH .'/Models/Db.php');
require_once(__DIR__. '/../Models/Db.php');

class Player extends Db {
    private $table = 'players';
    

    public function __construct($dbh = null) {
      
      parent::__construct($dbh);
    }
    /**
     * playersテーブルからすべてデータを取得（20件ごと）
     *
     * @param integer $page ページ番号
     * @return Array $result 全選手データ（20件ごと）
     */
    public function findAll($page= 0):Array {
      $sql = 'SELECT * FROM '.$this->table;
      $sql .= ' where del_flg =' . 0;
      $sql .= ' LIMIT 20 OFFSET '.(20 * $page);
      
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    

    public function grabCountry($id):Array {
      $sql = 'SELECT name FROM countries';
      $sql .= ' where id = '. $id;
      // $sql .= ' where id = 1';
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    public function repeat($word){
      return $word . $word;
    }

    /**
     * playersテーブルから全データ数を取得
     *
     * @return Int $count 全選手の件数
     */
    public function countAll():Int {
      $sql = 'SELECT count(*) as count FROM '.$this->table;
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $count = $sth->fetchColumn();
      return $count;
  }

    /**
     * playersテーブルから指定idに一致するデータを取得
     *
     * @param integer $id 選手のID
     * @return Array $result 指定の選手データ
     */
    public function findById($id = 0):Array {
      $sql = 'SELECT * FROM '.$this->table;
      $sql .= ' WHERE id = :id';
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      return $result;
    }
}