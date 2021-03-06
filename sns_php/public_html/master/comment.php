<?php


require_once(__DIR__ . '/../../config/config.php');
require_once(__DIR__ . '/../../lib/Controller/Comment.php');

$commentApp = new \MyApp\Controller\Comment();

?>

<!DOCTYPE html>
<html lang="ja" >
  <head>
    <meta charset="utf-8">
    <title>My Comments</title>
    <link rel="stylesheet" href="/css/styles_todo.css">
  </head>
  <body>
    <div id="container">
      <h1>Comments</h1>
      <button type="button" onclick="history.back()">戻る</button>
      <button id="logout"><a href="/master/logout.php" id="logout">LogOut</a></button>
      <form action="" id="new_comment_form" method="post">
        <input type="text" id="new_comment" name="user_name" placeholder="your_name?" value="<?=$commentApp->setUsernm();?>">
        <textarea id="new_comment" name="body" placeholder="Comments?"></textarea>
        <input type="submit" id="btn" value="Submit!">
        <input type="hidden" name="token" value="<?=h($_SESSION['token']);?>">
      </form>
      <ul id="todos">
      <li id="todo_template" data-id="">
      <input type="checkbox" class="update_todo">
      <span class="title"></span>
      <div id="todo_template" data-id=""><span class="body"></span></div>
      <div class="delete_todo">x</div>
      </li>

      </ul>
    </div>

    <input type="hidden" id="token" value="<?php echo h($_SESSION['token']); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="/js/todo.js"></script>

  </body>
</html>
