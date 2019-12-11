<?php

//ユーザーの一覧
//config.phpの呼び出し一つ上の移送のconfigフォルダ
require_once(__DIR__ . '/../../config/config.php');
require_once(__DIR__ . '/../../lib/Controller/Mtopics.php');

//MyApp/Controller/Index();のインスタンスの作成

$app = new MyApp\Controller\Mtopics();

?>
<!DOCTYPE html>
<html lang="ja" >
  <head>
    <meta charset="utf-8">
    <title>Make Topics!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/vader/jquery-ui.min.css">
        <link rel="stylesheet" href="/css/styles.css">
  </head>
  <body>

    <div id="header">
    		<form action="/master/logout.php" method="post" id="logout">
        <span>ようこそ　<?=h($app->me()->user_name); ?>さん</span> <button type="button" onclick="history.back()">戻る</button><input type="submit" name="" value="Log Out">
        <input type="hidden" name="token" value="<?=h($_SESSION['token']);?>">

      </form>
			<h1>Topics <div class="fs12">(<?=count($app->getValues()); ?>)</div> </h1>
 	</div>

 	<div id="sidebar">
 		<ul>
 			<div class="search_calendar"><span>画面右側にイベントカレンダーを表示</span><?php echo $app->setSidebar();?></div>
 			<li name="top"><a href="/master/index.php">トップ</a></li>
			<li name="category_name">検索　<input type="text" value="<?php echo $app->getResearch();?>"></li>
     	 	<li id="yahoo"><a href="https://www.yahoo.co.jp/">Yahoo!</a></li>
     	 	<li name="weather"><a href="/master/weather">天気予報</a></li>
     	 	<li name="todo"><a href="/master/todo.php">Todo</a></li>
     	 	<li name="category_all">カテゴリ検索</li>
                  <ul name="category_check_list[]">
                      <?php foreach($app->getCategory() as $data) { ?>
                      	<li><input type="checkbox" value="<?=h($data->category_id);?>"><img src="/img/category_id=<?=h($data->category_id);?>.png" id="img" width="40px" height="20px"></li>
                      <?php } ?>
                  </ul>
         	<div name="category_all"><button id="search">検索</button></div>
      	</ul>
 	</div>

 	<div id="containerA">
 		<form action="" id="ceate_topics" method="post" >
 			<div class="containerA">分類<input type="radio" name="kubun" value="0" checked> お知らせ  <input type="radio" name="kubun" name="kubun" value="1">
 			イベント日付<input type="text" id="datepicker1" name="start_date" value="javascript();" readonly>～
 			<input type="text" id="datepicker2" name="end_date" value="javascript();" readonly></div>
 			<div class="containerA"><span>公開日</span><input type="text" id="datepicker3" name="koukai_date" value="javascript();" readonly></div>
 			<div class="containerA"><span>カテゴリ</span><select name="category_id" id="category">
 				<?php foreach($app->getCategory() as $data) { ?>
                <option value="<?=h($data->category_id); ?>"><?=h($data->category_name); ?></option>
            	<?php } ?>
            	<option value="0" selected>選択してください</option>
            </select></div>
            <div class="containerA"><span>タイトル</span><input type="text" id="title" name="title" placeholder="title_in" value=""></div>
            <div class="containerA"><span>内容</span><textarea id="body" name="body" placeholder="edit"></textarea></div>
            <input type="submit" id="btn" value="Submit!">
            <input type="hidden" name="token" value="<?=h($_SESSION['token']);?>">
      	</form>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
  <script src="/js/topics.js"></script>
  <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
  <script>
	CKEDITOR.replace('body');

  </script>
  </body>

</html>
