<?php

//ユーザーの一覧
//config.phpの呼び出し一つ上の移送のconfigフォルダ
require_once(__DIR__ . '/../../config/config.php');

//MyApp/Controller/Index();のインスタンスの作成
$app = new MyApp\Controller\Index();

$app->run();

//$app->me()
//$app->getValues()->users

?>
<!DOCTYPE html>
<html lang="ja" >
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="/css/styles.css">
  </head>
  <body>
    <div id="containerA">
      <form action="/master/logout.php" method="post" id="logout">
        <?=h($app->me()->email); ?> <input type="submit" name="" value="Log Out">

        <input type="hidden" name="token" value="<?=h($_SESSION['token']);?>">
      </form>

      <p class="fs12"><a href="/master_admin/muser.php">ユーザ管理</a></p>
      <p class="fs12"><a href="/master_admin/mtopics.php">Topics管理</a></p>
      <p class="fs12"><a href="/master_admin/mtodo.php">Todo管理</a></p>
      <p class="fs12"><a href="/master_admin/mcalendar.php">Calendar管理</a></p>
      <p class="fs12"><a href="/master_admin/mwisp.php">Wisp管理</a></p>


      <h1>Menu <span class="fs12">(<?=count($app->getValues()->user) ?>)</span> </h1>
      <p class="fs12"><a href="/master/index.php">ホーム</a></p>
    </div>
  </body>
</html>