<?php

//ユーザーの一覧
//config.phpの呼び出し一つ上の移送のconfigフォルダ
require_once(__DIR__ . '/../../config/config.php');
require_once(__DIR__ . '/../../lib/Controller/Muser.php');

//MyApp/Controller/Index();のインスタンスの作成

$app = new MyApp\Controller\Muser();

?>
<!DOCTYPE html>
<html lang="ja" >
  <head>
    <meta charset="utf-8">
    <title>Make User!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/vader/jquery-ui.min.css">
        <link rel="stylesheet" href="/css/styles.css">
  </head>
  <body>

    <div id="header">
    		<form action="/master/logout.php" method="post" id="logout">
        <span>ようこそ　<?=h($app->me()->user_name); ?>さん</span> <button type="button" onclick="history.back()">戻る</button><input type="submit" name="" value="Log Out">
        <input type="hidden" name="token" value="<?=h($_SESSION['token']);?>">

      </form>
			<h1>User管理 <div class="fs12">(<?=count($app->getValues()); ?>)</div> </h1>
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
                      	<li><input type="checkbox" value="<?=h($data->category_id);?>"><img src="/img/category_id=<?=h($data->category_id);?>.ico" id="img" width="40px" height="20px"></li>
                      <?php } ?>
                  </ul>
         	<div name="category_all"><button id="search">検索</button></div>
      	</ul>
 	</div>

 	<div id="containerA">
 		<form action="" id="ceate_user" enctype="multipart/form-data" method="post" >
 			<div class="containerU"><span>ユーザ名</span><input type="text" id="user_id" name="user_name" value="<?php if(isset($_SESSION['me']->user_name)) { echo $_SESSION['me']->user_name;} else {echo '';} ?>" ></div>
 			<div class="containerU"><span>メールアドレス</span><input type="text" id="datepicker1" name="start_date" value="<?php if(isset($_SESSION['me']->email)) { echo $_SESSION['me']->email;} else {echo '';} ?>" ></div>
 			<div class="containerU"><span>パスワード</span><input type="text" id="datepicker3" name="koukai_date" ></div>
 			<div class="containerU"><span>ウェブ利用</span>利用しない<input type="radio" id="web_flg" name="web_flg" value="0" selected>利用する<input type="radio" id="web_flg" name="web_flg" value="1"></div>
            <div class="containerU"><span>有料会員登録</span>登録しない<input type="radio" id="premium_flg" name="premium_flg" value="0" selected>登録する<input type="radio" id="premium_flg" name="premium_flg" value="1"></div>
            <div class="containerU"><span>アイコン</span><input type="file" id="icon" name="icon" placeholder="edit"></div>
            <input type="submit" id="btn" value="Submit!">
            <input type="hidden" name="token" value="<?=h($_SESSION['token']);?>">
      	</form>
  </div>
  </body>

</html>
