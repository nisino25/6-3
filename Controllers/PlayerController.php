<?php
session_start();
if(!$_SESSION['isLoggedin']){

  $_SESSION['isLoggedin'] =false;
  $_SESSION['isAdmin'] =false;
  $_SESSION['validationList'] = null;
  $_SESSION['validationFlag'] = null;
}

require_once(__DIR__. '/../Models/Player.php');
require_once(__DIR__. '/../Models/Goal.php');
require_once(__DIR__. '/../Models/Pairing.php');
require_once(__DIR__. '/../Models/Country.php');
require_once(__DIR__. '/../Models/Users.php');
$GLOBALS['connection'] =  mysqli_connect('localhost', 'root', '', 'educure');


class PlayerController {
  private $request;   // リクエストパラメータ(GET,POST)// private $Player;
  private $Player; 
  private $Goal;
  private $Country;
  private $Pairing; 
  private $Users; 
  

  public function __construct(){
    $this->request['get'] = $_GET; 
    $this->request['post'] = $_POST; 

    $this->Player = new Player();

    // 別モデルと連携
    $dbh = $this->Player->get_db_handler();
    $this->Goal = new Goal($dbh);

    // 別モデルと連携
    // $dbh = $this->Player->get_db_handler();
    $this->Country = new Country($dbh);

    // 別モデルと連携
    // $dbh = $this->Pairing->get_db_handler();
    $this->Pairing = new Pairing($dbh);

    // 別モデルと連携
    // $dbh = $this->Pairing->get_db_handler();
    $this->Users = new Users($dbh);
    
    

  }

  public function index(){
      $page = 0;
        if(isset($this->request['get']['page'])) {
            $page = $this->request['get']['page'];
        }

        $players = $this->Player->findAll($page);
        $players_count = $this->Player->countAll();
        $params = [
            'players' => $players,
            'pages' => $players_count / 20
        ];
        return $params;
  }

  public function getCountry($id){
    
    return  $this->Player->grabCountry($id);

  }

  public function hello($word){
    return  $word;
  }

  public function view() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $player = $this->Player->findById($this->request['get']['id']);
    $params = [
      'player' => $player
    ];
    return $params;
  }

  public function detail() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $player = $this->Goal->findByPlayerId($this->request['get']['id']);
    $params = [
      'player' => $player
    ];
    return $params;
  }

  public function getEnemyCountry($id){
    
    return  $this->Pairing->grabEnemyCountry($id);

  }

  public function getGametime($id){
    
    return  $this->Pairing->grabGametime($id);

  }

  public function toggleFlag($id){
    $sql = ' update players set del_flg = 1 where id =' . $id;
    $result =mysqli_query(mysqli_connect('localhost', 'root', '', 'educure'), $sql);
    
    $this->updateaTable();
  }

  public function grabCountryList(){

    $countries = $this->Country->findAll();
    return $countries;
  }

  public function updateaTable(){
    $sql = 'DROP TABLE players_tmp';
    $result =mysqli_query($GLOBALS['connection'], $sql);
    $sql = "CREATE TABLE players_tmp AS SELECT * FROM players where del_flg = 0";
    $result =mysqli_query($GLOBALS['connection'], $sql);
  }

 

  public function sendData($id){
    
    if(isset($_POST['submit'])){
      // echo 'sent it ';
      $validationFlag = true;
      $validationList = [
          "uniform"=> true,
          "position"=> true,
          "name"=> true,
          "club"=> true,
          "birth"=> true,
          "height"=> true,
          "weight"=> true,
          "country"=> true,
      ];
      
      
      
      
      $uniform= $_POST['uniform']; 
      $position = $_POST['position'];
      $name = $_POST['name'];
      $club = $_POST['club'];    
      $birth = $_POST['birth'];  
      $height = $_POST['height'];  
      $weight = $_POST['weight'];  
      $country = $_POST['country']; 

      if(!$name){
        $validationList['name'] = '名前は必須入力です';
        $validationFlag = false;
      };

      if(!$uniform){
        $validationList['uniform'] = '背番号は必須入力です';
        $validationFlag = false;
      }else{
        $str = $uniform;
        for($i =0; $i<strlen($uniform); $i++){
            if($str[0] == '0' || $str[0] == '1' || $str[0] == '2'|| $str[0] == '3'|| $str[0] == '4'|| $str[0] == '5'|| $str[0] == '6'|| $str[0] == '7'|| $str[0] == '8' || $str[0] == '9'){
            } else{
                $validationList['uniform'] = '背番号は0-9の数字のみでご入力ください';
                $validationFlag = false;
            };
            $str = substr($str, 1);
        };
      }


      if(!$club){
        $validationList['club'] = '所属チームは必須入力です。';
        $validationFlag = false;
      }

      if(!$birth){
        $validationList['birth'] = '誕生日は必須入力です。';
        $validationFlag = false;
      }else{
        $parts = explode('-',$birth);
        $year =   $parts[0];
        $year = (int)$year;

        $month =  $parts[1];
        $month= (int)$month;

        $day =  $parts[2];
        $day= (int)$day;
        // $parts = explode('-', '2068-06-15');
        // echo $parts[0];
        if(!checkdate ( $month, $day, $year )){
          $validationList['birth'] = '存在しない日付です';
          $validationFlag = false;
        };
      };


      if(!$weight){
        $validationList['weight'] = '体重は必須入力です。';
        $validationFlag = false;
      }else{
        $str = $weight;
        for($i =0; $i<strlen($weight); $i++){
            if($str[0] == '0' || $str[0] == '1' || $str[0] == '2'|| $str[0] == '3'|| $str[0] == '4'|| $str[0] == '5'|| $str[0] == '6'|| $str[0] == '7'|| $str[0] == '8' || $str[0] == '9'){
            } else{
                $validationList['weight'] = '体重は0-9の数字のみでご入力ください';
                $validationFlag = false;
            };
            $str = substr($str, 1);
        };
      }


      if(!$height){
        $validationList['height'] = '身長は必須入力です。';
        $validationFlag = false;
      }else{
        $str = $height;
        for($i =0; $i<strlen($height); $i++){
            if($str[0] == '0' || $str[0] == '1' || $str[0] == '2'|| $str[0] == '3'|| $str[0] == '4'|| $str[0] == '5'|| $str[0] == '6'|| $str[0] == '7'|| $str[0] == '8' || $str[0] == '9'){
            } else{
                $validationList['height'] = '身長は0-9の数字のみでご入力ください';
                $validationFlag = false;
            };
            $str = substr($str, 1);
        };
      }

     $_SESSION['validationList'] = $validationList ;
      $_SESSION['validationFlag'] = $validationFlag ;
    // -------------------------------------------------------------

      if(!$validationFlag){
        return;
      }else{

        

      
        
        $uniform = mysqli_real_escape_string($GLOBALS['connection'],$uniform );
        $name = mysqli_real_escape_string($GLOBALS['connection'],$name );
        $club = mysqli_real_escape_string($GLOBALS['connection'],$club );
        $birth = mysqli_real_escape_string($GLOBALS['connection'],$birth );
        $height = mysqli_real_escape_string($GLOBALS['connection'],$height );
        $weight = mysqli_real_escape_string($GLOBALS['connection'],$weight );
        
        
        
        $sql = " update players set name = '". $name . "' ";
        $sql = " update players set club = '". $club . "' ";
        $sql = " update players set position = '". $position . "' ";
        $sql = " update players set birth = '". $birth . "' ";
        $sql .= ", country_id = ". $country . "";
        $sql .= ", uniform_num = ". $uniform . "";
        $sql .= ", height = ". $height . "";
        $sql .= ", weight = ". $weight . "";

        $sql .= " where id = " . $id;
        $result =mysqli_query($GLOBALS['connection'], $sql);

        $this->updateaTable();


        

        // INSERT INTO new_table (Foo, Bar, Fizz, Buzz) SELECT Foo, Bar, Fizz, Buzz FROM initial_table
    
        if(!$result){
          die('failed sending data. <br>'. mysqli_error($GLOBALS['connection']));
          
        }else{
          header("Location: ./index.php");
          die();
        }



      }

      
    }else{
      // echo 'not yet';
    }
  }

  public function register(){
    
    if(isset($_POST['submit'])){
      // echo 'sent it ';
      $validationFlag = true;
      $validationList = [
          "email"=> true,
          "password"=> true,
      ];
      
      
      
      
      $email= $_POST['email']; 
      $password = $_POST['password'];

      if(!$email){
        $validationList['email'] = 'メールは必須入力です';
        $validationFlag = false;
        
      }
      
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validationList['email'] = 'メールアドレスは正しくご入力ください。';
        $validationFlag = false;
      }
      
      $sql = "SELECT email from users where email = '$email'";
      $result = mysqli_query($GLOBALS['connection'], $sql);
      if(mysqli_num_rows($result)){
        $validationList['email'] = 'このメールアドレスは既に使用されています';
        $validationFlag = false;
      }

      if(!$password){
        $validationList['password'] = 'パスワードは必須入力です';
        $validationFlag = false;
      }


      
     $_SESSION['validationList'] = $validationList ;
      $_SESSION['validationFlag'] = $validationFlag ;
    // -------------------------------------------------------------

      if(!$validationFlag){
        return;
        echo 'failed';
      }else{

        

      
        
        $email = mysqli_real_escape_string($GLOBALS['connection'],$email );
        $password = mysqli_real_escape_string($GLOBALS['connection'],$password );
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        
        $sql = "INSERT INTO users(id, country_id, email, password, role) VALUES (NULL, 0, '$email', '$hash', 0)";

        $result =mysqli_query($GLOBALS['connection'], $sql);

        // $this->updateaTable();


        

        // INSERT INTO new_table (Foo, Bar, Fizz, Buzz) SELECT Foo, Bar, Fizz, Buzz FROM initial_table
    
        if(!$result){
          die('failed sending data. <br>'. mysqli_error($GLOBALS['connection']));
          
        }else{
          $_SESSION['isLoggedin'] = true;
          $_SESSION['logedinEmail'] = $email;
          header("Location: ./index.php");
          die();
        }



      }

      
    }else{
      // echo 'not yet';
    }
  }

  public function login(){
    
    if(isset($_POST['submit'])){
      // echo 'sent it ';
      $validationFlag = true;
      $validationList = [
          "email"=> true,
          "password"=> true,
      ];
      
      $email= $_POST['email']; 
      $password = $_POST['password'];

      if(!$email){
        $validationList['email'] = 'メールは必須入力です';
        $validationFlag = false;

      }if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validationList['email'] = 'メールアドレスは正しくご入力ください。';
        $validationFlag = false;
      }

      if(!$password){
        $validationList['password'] = 'パスワードは必須入力です';
        $validationFlag = false;
      }


      
     $_SESSION['validationList'] = $validationList ;
      $_SESSION['validationFlag'] = $validationFlag ;
    // -------------------------------------------------------------

      if(!$validationFlag){

        echo '<br>failed';
        return;
      }else{

        // start login varificataion ------------------------
        // if the user exists -----===================-------------------

        $sql = "SELECT email from users where email = '$email'";
        $result =mysqli_query($GLOBALS['connection'], $sql);

     
        if(!mysqli_num_rows($result)){
            $validationList['email'] = 'メールアドレスか存在しません';
            $validationFlag = false;
            echo '<br>メールアドレスか存在しません';
            return;
        }else{
            // if the password matches --===============----------------------
            $results = $this->Users->getRow($email);
            $hash = $results[0]['password'];
            // echo $hash;
            if(!password_verify($password, $hash)){
                $validationList['email'] = 'メールアドレスかパスワードが違います';
                $validationFlag = false;
                echo '<br>メールアドレスかパスワードが違います';
                return;
            }else{
                // procced login ---------======---------------  
                $_SESSION['isLoggedin'] = true;
                $_SESSION['logedinEmail'] = $email;
                if($results[0]['role'] == 1){
                  $_SESSION['isAdmin'] = true;
                }else{
                  $_SESSION['isAdmin'] = false;
                }
                header("Location: ./index.php");
                die();
                
            }
            
            
        }

        

      
        
        



      }

      
    }else{
      // echo 'not yet';
    }
  }

  public function logout(){
    if($_SESSION['isLoggedin']){
      $_SESSION['isLoggedin'] = false;
      $_SESSION['logedinEmail'] = null;
      $_SESSION['isAdmin'] = false;
      
    }else{
    }
  }






  
}