<?php

// session_start();

require_once(__DIR__ . '/../../config/config.php');
require_once(__DIR__ . '/../master/_ajax.php');
require_once(__DIR__ . '/../../lib/Controller/Todo.php');

//get Todos
$todoApp = new \MyApp\Controller\Todo();
$todos = $todoApp-> getAll();

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
      <h1>Todos</h1>
      <a href="/master/index.php">トップ</a>
      <button id="logout"><a href="/master/logout.php" id="logout">LogOut</a></button>
      <form  action="" id="new_todo_form" >
        <input type="text" id="new_todo" placeholder="What needs to be done?" value="">
        <textarea id="new_todo" placeholder="Details?"></textarea>
        <input type="submit" id="btn" value="Submit!">

      </form>
      <ul id="todos">
<!--       全選択ラジオボタン -->
		<table class="margin">
        	<input type="checkbox" class="all_check" value="すべてチェック">
        	<div class="all_delete" ><button id="btn">Delete_All</button></div>
        </table>
        <?php foreach($todos as $todo): ?>
          <li id="todo_<?= h($todo->todo_id); ?>"  data-id="<?=h($todo->todo_id); ?>">
            <input type="checkbox" id="list" class="update_todo" <?php if($todo->state === '1') {echo 'checked';} ?> >
            <span class="title <?php if($todo->state === '1'){echo 'done';} ?>"><a href="/master/edit.php?todo_id=<?= h($todo->todo_id); ?>"><?= h($todo->title); ?></a></span><div class="delete_todo" >x</div>
            <br><div class="comment_todo" ><a href="/master/comment.php?todo_id=<?= h($todo->todo_id); ?>">返信</a></div>
            <div id="<?= h($todo->todo_id); ?>" data-id="<?=h($todo->todo_id);?>"><span class="body <?php if($todo->state === '1'){echo 'done';} ?>"><?= h($todo->body); ?></span></div>
            <ul>
            <?php $i = 1;?>
                <?php if ($todoApp->getAllComments($todo->todo_id) != '') { ?>
                    <?php foreach ($todoApp->getAllComments($todo->todo_id) as $data) { ?>
                    	<li><div><?php echo $i++. '. ' . $data->user_name;?></div><span class="comment <?php if($todo->state === '1'){echo 'done';} ?>"><?= $data->body; ?></span></li>
                    <?php } ?>
                <?php } ?>
            </ul>

          </li>
      <?php endforeach; ?>
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
