<?php
  require_once(__DIR__ .'/../../Controllers/PlayerController.php');
  // sendData($params['player']['id']);
  // session_start();
  $controller = new PlayerController();
  // $params = $controller->view();
  // $countries = $controller->grabCountryList();
  // $detail = $controller->detail();

  $controller->login();
  // $controller->register();

  $validationList = $_SESSION['validationList'];
  $validationFlag = $_SESSION['validationFlag'];?>
<head>
  <link rel="stylesheet" type="text/css" href="../../public/css/registration.css">
</head>
<div class="container">
  <h1>ログイン</h1>
  <hr>
  <form name="myform" action="login.php" method="post" >

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
        <input style=" width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; resize: vertical;" type="text" id="email" name="email" placeholder="メールアドレス.." value="<?php echo isset
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