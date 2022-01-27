<?php
require_once(__DIR__ .'/../../Controllers/PlayerController.php');
// sendData($params['player']['id']);
// session_start();
$controller = new PlayerController();
$params = $controller->view();
$countries = $controller->grabCountryList();
$detail = $controller->detail();

$controller->sendData($params['player']['id']);

$validationList = $_SESSION['validationList'];
$validationFlag = $_SESSION['validationFlag'];
?>
<!DOCTYPE html> 
<html>
<head>
    <meta charset="UTF-8">
    <title>オブジェクト指向 - 選手詳細</title>
    <link rel="stylesheet" type="text/css" href="../../public/css/base.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
    <script> 
        function validateForm() {
            let name = document.querySelector('.name').value;
            let kana = document.querySelector('.kana').value;
            let tel = document.querySelector('.tel').value;
            let email  = document.querySelector('.email').value;
            let main = document.querySelector('.main').value;

            let flag = true;
            let warning = ''

            if(!flag) alert(`${warning}`);
            
            return true; 
        }

    </script>
</head>
<body>
    <h1 style="text-align:center">「<?=$params['player']['name'] ?>」を編集中</h1>
    <hr>
    <section>

      <form name="myform" action="edit.php?id=<?=$params['player']['id'] ?>" method="post" onsubmit="return confirm('送信してもよろしいですか？');">
        <dl>

          <dt><label for="uniform">背番号</label><span class="required" style="color: red">*</span></dt>
          <?php 
            if(isset($_POST['submit'])){
              if($validationList['uniform'] !== true){
                echo '<dd class="error" style="color:red">' . $validationList['uniform'] . '</dd>';
                // echo 'weonggg';
              }
                
            }
          ?> 
          <dd><input class="uniform" type="text" name="uniform" id="uniform" placeholder="背番号" value="<?php echo isset($_POST["uniform"]) ? $_POST["uniform"] : $params['player']['uniform_num'] ?>"></dd>
          <br>



          <dt><label for="position">ポジション</label>
          <br>
          <select id="positiopn" name="position">
          <?php
          $positions = array('MF','GK','DF','FW');
          foreach($positions as $position) {
              echo "<option ". ($params['player']['position'] == $position? 'selected="selected"': '') ."value='$position'>" . $position. "</option>";
          }
          ?>
          </select>
          <br><br>



          <dt><label for="name">名前</label><span class="required" style="color: red">*</span></dt>
          <?php 
            if(isset($_POST['submit'])){
              if($validationList['name'] !== true) echo '<dd class="error" style="color:red">' . $validationList['name'] . '</dd>';
            }else{
            }
          ?> 
          <dd><input class="name" type="text" name="name" id="name" placeholder="名前" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : $params['player']['name']; ?>"></dd>
          <br><br>



          <dt><label for="team">所属</label><span class="required" style="color: red">*</span></dt>
          <?php 
            if(isset($_POST['submit'])){
              if($validationList['club'] !== true) echo '<dd class="error" style="color:red">' . $validationList['club'] . '</dd>';
            }
          ?> 
          <dd><input class="name" type="text" name="club" id="club" placeholder="所属" value="<?php echo isset
          ($_POST["name"]) ? $_POST["club"] : $params['player']['club']; ?>"></dd>
          <br>


          

          <dt><label for="birth">誕生日</label><span class="required" style="color: red">*</span></dt>
          <?php 
            if(isset($_POST['submit'])){
              if($validationList['birth'] !== true) echo '<dd class="error" style="color:red">' . $validationList['birth'] . '</dd>';
            }
          ?> 
          <dd><input class="name" type="text" name="birth" id="birth" placeholder="誕生日" value="<?php echo isset($_POST["name"]) ? $_POST["birth"] : $params['player']['birth']; ?>"></dd>
          <br>




          <dt><label for="height">身長</label><span class="required" style="color: red">*</span></dt>
          <?php 
            if(isset($_POST['submit'])){
              if($validationList['height'] !== true) echo '<dd class="error" style="color:red">' . $validationList['height'] . '</dd>';
            }
          ?> 
          <dd><input class="name" type="text" name="height" id="height" placeholder="身長" value="<?php echo isset($_POST["name"]) ? $_POST["height"] : $params['player']['height']; ?>"></dd>
          <br>



          <dt><label for="weight">体重</label><span class="required" style="color: red">*</span></dt>
          <?php 
            if(isset($_POST['submit'])){
              if($validationList['weight'] !== true) echo '<dd class="error" style="color:red">' . $validationList['weight'] . '</dd>';
            }
          ?> 
          <dd><input class="name" type="text" name="weight" id="weight" placeholder="体重" value="<?php echo isset($_POST["name"]) ? $_POST["weight"] : $params['player']['weight']; ?>"></dd>
          <br>



          <dt><label for="country">出身国</label><br>
          <select id="country" name="country">
          <?php
          foreach($countries as $index => $country) {
              echo "<option ". ($index+1 == $params['player']['country_id']? 'selected="selected"': '')  ."value='$index +1'>" . $country['name']. "</option>";
          }
          ?>
          </select>


          
          <br>
          <br>
          <dd><button type="submit" name="submit">送　信</button></dd>

      </form>

      <br><br>
      <a href="index.php">Go back</a>
    </section>

    

</body>
</html>