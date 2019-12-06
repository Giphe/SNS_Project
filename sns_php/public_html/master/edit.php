<?php

// session_start();

require_once(__DIR__ . '/../../config/config.php');
require_once(__DIR__ . '/../../lib/Controller/Todo.php');
require_once(__DIR__ . '/../../lib/Controller/Edit.php');


//get Todos
$todoApp = new \MyApp\Controller\Edit();

// var_dump($todos);
// exit;

?>

<!DOCTYPE html>
<html lang="ja" >
  <head>
    <meta charset="utf-8">
    <title>My Todos</title>
    <link rel="stylesheet" href="/css/styles_todo.css">
  </head>
  <body>
    <div id="container">
      <h1>Edit</h1>
      <button type="button" onclick="history.back()">戻る</button>
      <button id="logout"><a href="/master/logout.php" id="logout">LogOut</a></button>
      <form  action="" id="new_comment_form" method="post" >
        <input type="text" name="title" id="new_comment" placeholder="What needs to be done?" value="<?=h($todoApp->setTitle());?>">
        <textarea id="new_comment" name="body" placeholder="Details?"><?=h($todoApp->setBody());?></textarea>
        <input type="hidden" name="token" value="<?=h($_SESSION['token']);?>">
        <input type="submit" id="btn" value="Save!">

      </form>
    </div>

    <input type="hidden" id="token" value="<?php echo h($_SESSION['token']); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="/js/todo.js"></script>

  </body>
</html>
