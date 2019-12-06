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
    <div id="container">
      <form action="/master/logout.php" method="post" id="logout">
        <a href="/master_admin/menu.php"><?=h($app->me()->user_name); ?></a> <input type="submit" name="" value="Log Out">

        <input type="hidden" name="token" value="<?=h($_SESSION['token']);?>">
      </form>

      <p class="fs12"><a href="/master/calendar.php">Calendar</a></p>
      <p class="fs12"><a href="/master/topics.php">Topics</a></p>
      <p class="fs12"><a href="/master/wisp.php">Wisp</a></p>
      <p class="fs12"><a href="/master/todo.php">Todos</a></p>
      <p class="fs12"><a href="/master/generate_word.php">Words</a></p>


      <h1>Users <span class="fs12">(<?=count($app->getValues()->users) ?>)</span> </h1>
      <ul>
        <?php foreach($app->getValues()->users as $user): ?>
          <li><?=h($user->email); ?>
          	<ul>
          		<li><?=h($user->user_name); ?></li>
	            <li><?=h($user->modified); ?></li>
          	</ul>
          </li>

        <?php endforeach; ?>
      </ul>
    </div>
  </body>
</html>
