<?php

//ユーザーの一覧
//config.phpの呼び出し一つ上の移送のconfigフォルダ
require_once(__DIR__ . '/../../config/config.php');
require_once(__DIR__ . '/../../lib/Controller/Topics.php');

//MyApp/Controller/Index();のインスタンスの作成

$app = new MyApp\Controller\Topics();
$topicsApp = $app->getValues();

?>
<!DOCTYPE html>
<html lang="ja" >
  <head>
    <meta charset="utf-8">
    <title>Topics</title>

    <link rel="stylesheet" href="/css/styles.css">
  </head>
  <body>

    <div id="header">
    		<form action="/master/logout.php" method="post" id="logout">
        <p>ようこそ　<?=h($app->me()->user_name); ?>さん</p> <input type="submit" name="" value="Log Out">
        <input type="hidden" name="token" value="<?=h($_SESSION['token']);?>">
      </form>
			<h1>Topics <span class="fs12">(<?=count($app->getValues()); ?>)</span> </h1>
 	</div>

 	<div id="sidebar">
 	<div class="search_calendar"><p>画面右側にイベントカレンダーを表示</p><?php echo $app->setSidebar();?></div>
 		<ul>
 			<li name="top"><a href="/master/index.php">トップ</a></li>
 			<li name="mtopics"><a href="/master_admin/mtopics.php">投稿</a></li>
			<li name="category_name">検索　<input type="text" value="<?php echo $app->getResearch();?>"></li>
     	 	<li><a href="https://www.yahoo.co.jp/">Yahoo!</a></li>
     	 	<li name="weather"><a href="/master/weather">天気予報</a></li>
     	 	<li name="todo"><a href="/master/todo.php">Todo</a></li>
     	 	<li name="category_all">カテゴリ検索</li>
                  <ul name="category_check_list[]">
                      <?php foreach($app->getCategory() as $data) { ?>
                      	<li><input type="checkbox" value="<?=h($data->category_id);?>"><img src="/img/category_id=<?=h($data->category_id);?>.ico" id="img" width="40px" height="20px"></li>
                      <?php } ?>
                  </ul>
         	<div name="category_all"><button id="search">検索</button></div>
      	</ul>
 	</div>

 	<div id="containerA">
 	<?php $cnt=1;?>
 		<?php foreach($topicsApp as $data) { ?>
 		<?php $cnt++;?>
 		<ul>
     		<li id="tnumber"><?=h($cnt++);?></li><div id="tkoukai_date"><?=h($data->koukai_date);?></div><img src="/img/category_id=<?=h($data->category_id)?>.ico" width="40px" height="20px">
     		<li id="tstart_date"><?=strpos('Ymd', h($data->start_date));?>～<?=strpos('Ymd', h($data->end_date));?></li>
     		<li id="ttitle"><?=h($data->title);?></li>
     		<br><li id="tbody"><?=$data->body;?></li>
 		</ul>
 		<br>
 		<?php } ?>
  </div>
  </body>
</html>
