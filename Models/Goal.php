<?php 
require_once(__DIR__.'/../Models/Db.php');

class Goal extends Db {
    private $table = 'goals';

    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }

    /**
     * goalsテーブルから指定player_idに一致するデータを取得
     *
     * @param integer $id 選手のID
     * @return Array $result 選手のゴールデータ
     */
    public function findByPlayerId($id = 0):Array {
        // $sql = 'SELECT * FROM '.$this->table;
        $sql = 'SELECT p.kickoff as kickoff,';
        $sql .= '(SELECT c.name FROM countries c WHERE p.enemy_country_id = c.id) AS enemy,';
        $sql .= 'g.goal_time';
        $sql .= ' FROM goals g left join pairings p on g.pairing_id = p.id';
        $sql .= ' WHERE player_id = ' . $id;
        $sql .= ' order by kickoff';
        $sth = $this->dbh->prepare($sql);
        // $sth->bindParam(':player_id', $id, PDO::PARAM_INT);
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