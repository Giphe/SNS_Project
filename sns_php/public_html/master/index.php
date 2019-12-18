<?php

//ユーザーの一覧
//config.phpの呼び出し一つ上の移送のconfigフォルダ
require_once(__DIR__ . '/../../config/config.php');

//MyApp/Controller/Index();のインスタンスの作成
$app = new MyApp\Controller\Index();

$app->run();

//$app->me()
//$app->getValues()->user

?>
<!DOCTYPE html>
<html lang="ja" >
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="/css/styles.css">
  </head>
  <body>
    <div id="header">
      <form action="/master/logout.php" method="post" id="logout">
        <a href="/master_admin/menu.php"><?=h($app->me()->user_name); ?></a> <input type="submit" name="" value="Log Out">

        <input type="hidden" name="token" value="<?=h($_SESSION['token']);?>">
      </form>

      <h1>Users <span class="fs12">(<?=count($app->getValues()->user) ?>)</span> </h1>
      <ul>
        <?php foreach($app->getValues()->user as $user): ?>
          <li><?=h($user->email); ?>
          	<ul>
          		<li><?=h($app->me()->user_name); ?></li>
	            <li><?=h($app->me()->modified); ?></li>
          	</ul>
          </li>

        <?php endforeach; ?>
      </ul>
    </div>
    <div id="sidebar">
    	<ul>
            <li id="calendar"><a href="/master/calendar.php">Calendar</a></li>
            <li id="topics"><a href="/master/topics.php">Topics</a></li>
            <li id="wisps"><a href="/master/wisp.php">Wisp</a></li>
            <li id="todos"><a href="/master/todo.php">Todos</a></li>
            <li id="words"><a href="/master/generate_word.php">Words</a></li>
      	</ul>
    </div>
    <div id="containerA">
    	<ul>
    		<div class="containerU">こんにちは！<?php if(isset($_SESSION['me']->user_name)) { echo $_SESSION['me']->user_name;} else {echo '';} ?>さん</div>
 			<?php if(isset($_SESSION['me']->icon)) { ?>
 				<div class="containerU"><img src="/../img/icon/<?= h($_SESSION['me']->icon); ?>" name="icon" width="80px" height="80px"></div>
 			<?php } ?>
 			<div class="containerU"><span>フォロー</span>
     			<ul>
         			<?php foreach($app->getValues()->follow as $follow) { ?>
    	     			<li><?=$follow->follower_name?></li>
         			<?php } ?>
     			</ul>
 			</div>
 			<div class="containerU"><span>フォロワー</span>
     			<ul>
         			<?php foreach($app->getValues()->follower as $follower) { ?>
    	     			<li><?=$follower->follower_name?></li>
         			<?php } ?>
     			</ul>
 			</div>
 			<div class="containerU"><span>電話番号</span><input type="tel" inputmode="tel" placeholder="080-1234-5678" name="tel" value="<?php if(isset($_SESSION['me']->tel)) { echo $_SESSION['me']->tel;} else {echo '';} ?>" ></div>
 			<li><?php if(isset($_SESSION['me']->shokai)) { echo $_SESSION['me']->shokai;} else {echo '';} ?></li>

    	</ul>
    </div>
    <div id="footer">
    </div>

  </body>
</html>
