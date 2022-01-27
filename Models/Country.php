<?php 
require_once(__DIR__.'/../Models/Db.php');

class Country extends Db {
    private $table = 'countries';

    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }

    /**
     * goalsテーブルから指定player_idに一致するデータを取得
     *
     * @param integer $id 選手のID
     * @return Array $result 選手のゴールデータ
     */
    public function findAll():Array {
      $sql = 'SELECT name FROM '.$this->table;
      // $sql .= ' where del_flg =' . 0;
      // $sql .= ' LIMIT 20 OFFSET '.(20 * $page);
      
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

  
}

// SELECT p.kickoff as kickoff,
// (SELECT c.name FROM countries c WHERE p.enemy_country_id = c.id) AS enemy,
// g.goal_time
// FROM goals g left join pairings p on g.pairing_id = p.id 
// WHERE player_id = 181
// order by kickoff