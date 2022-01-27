<?php
require_once(__DIR__ .'/../../Controllers/PlayerController.php');
$controller = new PlayerController();
$params = $controller->view();
$detail = $controller->detail();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>オブジェクト指向 - 選手詳細</title>
    <link rel="stylesheet" type="text/css" href="../../public/css/base.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
</head>
<body>
    <h1>オブジェクト指向の練習プログラム</h1>
    <hr>
    <section>
        <article>
            <h2>選手詳細</h2>
            <table>
              <tr>
                  <th>No</th>
                  <td><?=$params['player']['id'] ?></td>
              </tr>
              <tr>
                  <th>背番号</th>
                  <td><?=$params['player']['uniform_num'] ?></td>
              </tr>
              <tr>
                  <th>ポジション</th>
                  <td><?=$params['player']['position'] ?></td>
              </tr>
              <tr>
                  <th>名前</th>
                  <td><?=$params['player']['name'] ?></td>
              </tr>
              <tr>
                  <th>所属</th>
                  <td><?=$params['player']['club'] ?></td>
              </tr>
              <tr>
                  <th>誕生日</th>
                  <td><?=$params['player']['birth'] ?></td>
              </tr>
              <tr>
                  <th>身長</th>
                  <td><?=$params['player']['height'] ?>cm</td>
              </tr>
              <tr>
                  <th>体重</th>
                  <td><?=$params['player']['weight'] ?>kg</td>
              </tr>
              <tr>
                  <th>出身国</th>
                  <td><? $theId = $params['player']['country_id'];
                  $array = $controller->getCountry($theId);
              print_r($array[0]['name']) ?></td>
              </tr>
              
              <tr>
                  <td class='actions' colspan='2'>
                      <a href=''>編集</a>
                      <a href='javascript:void(0)' onclick="return confirm('<?=$params['player']['id'] ?>を削除します。よろしいですか？')">削除</a>
                  </td>
              </tr>
            </table>

            <p class='pageback'><a href='javascript:history.back()'>トップへ戻る</a></p>
        </article>

        <article>
            <h2>得点履歴</h2>
            <table>
          <tr>
              <th>点数</th>
              <th>試合委日時</th>
              <th>対戦相手</th>
              <th>ゴールタイム</th>
              <th>&nbsp;</th>
          </tr>
          <?php foreach($detail['player'] as $index => $player): ?>
          <tr>
              <td><?=$index+ 1 ?></td>
              <td><?= $player['kickoff'] ?></td>
              <td><?= $player['enemy'] ?></td>
              <td><?= $player['goal_time'] ?></td>
              
              

          </tr>
          <?php endforeach; ?>
        </table>

            <p class='pageback'><a href='javascript:history.back()'>トップへ戻る</a></p>
        </article>
    </section>

</body>
</html>