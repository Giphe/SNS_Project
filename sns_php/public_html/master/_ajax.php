<?php

require_once(__DIR__ . '/../../config/config.php');
// require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/../../lib/Controller/Todo.php');
require_once(__DIR__ . '/../../lib/Controller/Index.php');


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //todo.phpのajax処理
    if(strpos($_SERVER['HTTP_REFERER'], 'master/todo.php') !== false){

        $todoApp = new MyApp\Controller\Todo();
        try{
            $res = $todoApp ->post();
            header('Content-Type: application/json');
            echo json_encode($res);
            return $res;
            exit;
        }catch(Exception $e){
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error' , true, 500);
            echo $e->getMessage();
            exit;
        }
    }

    //index.phpのajax処理
    if(strpos($_SERVER['HTTP_REFERER'], 'master/index.php') !== false){

        $indexApp = new MyApp\Controller\Index();
        try{
            $res = $indexApp ->post();
            header('Content-Type: application/json');
            echo json_encode($res);
            return $res;
            exit;
        }catch(Exception $e){
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error' , true, 500);
            echo $e->getMessage();
            exit;
        }
    }
}
