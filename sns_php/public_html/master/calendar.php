<?php

//ユーザーの一覧
//config.phpの呼び出し一つ上の移送のconfigフォルダ
require_once(__DIR__ . '/../../config/config.php');

//MyApp/Controller/Index();のインスタンスの作成
$app = new MyApp\Controller\Calendar();

$app->run();

?>

<!DOCTYPE html>
<html lang="ja" >
  <head>
    <meta charset="utf-8">
    <title>Calendar</title>
    <link rel="stylesheet" href="/css/styles.css">
  </head>
  <body>
      <form action="calendar.php" method="post" id="calendar">
        <table>
          <thead>
            <tr>
              <th><a href="/master/calendar.php/?t=<?php echo h($app->prev); ?>">&laquo;</a></th>
              <th colspan="5"><?php echo h($app->yearMonth); ?></th>
              <th><a href="/master/calendar.php/?t=<?php echo h($app->next); ?>">&raquo;</a></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Sun</td>
              <td>Mon</td>
              <td>Tue</td>
              <td>Wed</td>
              <td>Thu</td>
              <td>Fri</td>
              <td>Sat</td>
            </tr>
            <?php echo $app->show(); ?>

          </tbody>
          <tfoot>
            <tr>
              <th colspan="7"><a href="/calendar.php/">Today</a></th>
            </tr>
          </tfoot>
        </table>
    </form>
  </body>
</html>
