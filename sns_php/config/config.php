<?php

ini_set('display_errors', 1);

define('DSN', 'mysql:dbhost=localhost;dbname=SNS_Project');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'yama8ky7');

define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('bathPath', 'http://' . $_SERVER['HTTP_HOST'] . '/master');

//TODO:いらなかったら削除myfuncで認証系は十分
require_once(__DIR__. '/../lib/functions.php');

//require_once(__DIR__. '/../lib/myfunc.php');
require_once(__DIR__. '/autoload.php');

// TODO: dispacher acteivate
// $dispachar = new Dispacher();



session_start();
