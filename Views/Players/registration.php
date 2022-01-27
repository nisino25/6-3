<?php
  require_once(__DIR__ .'/../../Controllers/PlayerController.php');
  // sendData($params['player']['id']);
  // session_start();
  $controller = new PlayerController();
  // $params = $controller->view();
  // $countries = $controller->grabCountryList();
  // $detail = $controller->detail();

  $controller->register();

  $validationList = $_SESSION['validationList'];
  $validationFlag = $_SESSION['validationFlag'];?>
<head>
  <link rel="stylesheet" type="text/css" href="../../public/css/registration.css">
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
<div class="container">
  <h1>新規登録</h1>
  <hr>
  <form name="myform" action="registration.php" method="post" onsubmit="return confirm('送信してもよろしいですか？');">

    <div class="row">
      <div class="col-25">
        <label for="email">Email</label>
      </div>
      <div class="col-75">
      <?php 
          if(isset($_POST['submit'])){
            if($validationList['email'] !== true){
              echo '<dd class="error" style="color:red">' . $validationList['email'] . '</dd>';
              // echo 'weonggg';
            }
              
          }
        ?> 
        <input type="text" id="email" name="email" placeholder="メールアドレス.." value="<?php echo isset
          ($_POST["email"]) ? $_POST["email"] : ''; ?>">
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="password">パスワード</label>
      </div>
      <div class="col-75">
        <?php 
          if(isset($_POST['submit'])){
            if($validationList['password'] !== true){
              echo '<dd class="error" style="color:red">' . $validationList['password'] . '</dd>';
              // echo 'weonggg';
            }
              
          }
        ?> 
        <input style=" width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; resize: vertical;" type="password" id="password" name="password" placeholder="パスワード.." value="<?php echo isset
          ($_POST["password"]) ? $_POST["password"] : ''; ?>">
      </div>
    </div>

    

    
    
    <div class="row">
      <input type="submit" name="submit">
      <!-- <dd><button type="submit" name="submit">送　信</button></dd> -->
    </div>
  </form>
  <div style="margin-left:20px">
    <a href="index.php">戻る </a>
  </div>
</div>