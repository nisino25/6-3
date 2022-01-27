<?php
require_once(__DIR__. '/../../Controllers/PlayerController.php');
$controller = new PlayerController();
$params = $controller->index();

?>
<!-- <p><?=$params['test']?></p> -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>オブジェクト指向 - 選手一覧</title>
    <link rel="stylesheet" type="text/css" href="../../public/css/base.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
    <script>

        function deletingConfirmation(num) {   
            let text = 'id No.' + num + ' を削除しますか？' ;
            
            if (confirm(text) == true) {

                window.location = (`./delete.php?id="${num}"`) 
            } else {
                // text = "You canceled!";
            }
            // document.getElementById("demo").innerHTML = text;
        }  
      </script>
</head>
<body>
    <h1>オブジェクト指向の練習プログラム</h1>
    <?php 
        // echo 
        if(!($_SESSION['isLoggedin'])){
            echo '<br>
            <a href="registration.php">新規登録 </a>
            <br>
            <a href="login.php">ログイン </a>';
        }else{
            echo '<strong>ようこそ ' . $_SESSION['logedinEmail'] .  '</strong>' ; 
            echo '<br> <a href="logout.php">ログアウト</a>';
        }
    ?> 

            
    <hr>
    <section>
        <h2>選手一覧</h2>
        <table>
          <tr>
              <th>No</th>
              <th>背番号</th>
              <th>ポジション</th>
              <th>名前</th>
              <th>所属</th>
              <th>誕生日</th>
              <th>身長</th>
              <th>体重</th>
              <th>出身国</th>
              <th>&nbsp;</th>
          </tr>
          <?php foreach($params['players'] as $player): ?>
          <tr>
              <td><?=$player['id'] ?></td>
              <td><?=$player['uniform_num'] ?></td>
              <td><?=$player['position'] ?></td>
              <td><?=$player['name'] ?></td>
              <td><?=$player['club'] ?></td>
              <td><?=$player['birth'] ?></td>
              <td><?=$player['height'] ?>cm</td>
              <td><?=$player['weight'] ?>kg</td>
              <td><?  $theId = $player['country_id'];$array = $controller->getCountry($theId);
              print_r($array[0]['name'])
              ?></td> 
              <td class='actions'>
                  <a href="view.php?id=<?=$player['id'] ?>">詳細</a>
                  <?php echo ($_SESSION["isAdmin"]) ? "<a href='edit.php?id=<?=". $player['id'] . "?>'>編集</a>" : ''; ?>
                  
                  <?php echo ($_SESSION["isAdmin"]) ? "<td><input type = 'button' onclick = 'deletingConfirmation(". $player['id'] . ")' value = '削除'></td>"   : ''; ?>
              </td>
          </tr>
          <?php endforeach; ?>
        </table>
        
        <div class='paging'>
        <?php 
        for($i=0;$i<=$params['pages'];$i++) {
            if(isset($_GET['page']) && $_GET['page'] == $i) {
                echo $i+1;
            } else {
                echo "<a href='?page=".$i."'>".($i+1)."</a>";
            }
        }
        ?>
        </div>
    </section>

</body>
</html>