<?php

//CSRF対策
//コントローラーを読み込んでから,indexacionでindexを呼び出す仕組み

namespace MyApp\Controller;

class Edit extends \MyApp\Controller {

    //パラメータを取得
    private $_db;
    protected $user_id;
    protected $user_name;
    protected $todo_id;

    public function indexAction () {
        //パラメータを取得
        $state = 1;

        //取得したパラメータをviewにセット
        $this->view->set('state', $state);
    }

    //:TODOtokenはすでに作成済みいらなくなったら消す
    public function __construct(){

        //セッションの値を格納
        $this->user_name = $_SESSION['me']->user_name;

        //CSRF対策
        $this->_createToken();
        try{
            $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $e){
            echo $e->getMessage();
            exit;
        }

        if (!isset($_REQUEST['todo_id'])){

        } else {
            //リクエストされた値を格納
            $this->todo_id = $_REQUEST['todo_id'];
            $this->parameter = $this->getTodo();
            $this->title = $this->parameter[0]->title;
            $this->body = $this->parameter[0]->body;
        }

        if($_SERVER["REQUEST_METHOD"] != "POST"){
            // ブラウザからHTMLページを要求された場合
            if ($this->user_name != '') {
                $this->user_name = $_SESSION['me']->user_name;
            }
            //セッション変数のuser_nameの値をそのまま渡す

        }else{
            // フォームからPOSTによって要求された場合
            $this->_validateToken();

            //ポストされた値を格納
            $this->todo_id = $_REQUEST['todo_id'];
            $this->title = $_POST['title'];
            $this->body = $_POST['body'];

            try {

                if (isset($this->user_name)) { //$this->user_name == null
                    if (isset($this->body)) { // $this->body == null
                        $this->updateTodo($this->todo_id);
                    } else {
                        throw new \MyApp\Exception\InvalidEmail();
                    }
                } else {
                    throw new \MyApp\Exception\InvalidEmail();
                }

            }catch (\MyApp\Exception\InvalidEmail $e) {
                $this->setErrors('user_name', $e->getMessage());
            }

        }
        return;
    }

    /*
     * _createToken
     * @param
     * tokenを生成
     */
    private function _createToken(){
        if(!isset($_SESSION['token'])){
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }
    }


    /*
     * _validateToken
     * @param
     *
     */
    private function _validateToken(){
        if(!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']){
            throw new \Exception('invalid token!');
        }
        if(!isset($_SESSION['me']) && !isset($_POST['me'])){
            throw new \Exception('invalid me!');
        }
    }

    /* Todo情報を取得
     * getTodo
     * @param $todo_id
     */
    public function getTodo(){
        $stmt = $this->_db->query(sprintf("select * from t_todos where todo_id = %d", $_REQUEST['todo_id']));
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /* titleを取得
     * setTitle
     * @param
     */
    public function setTitle(){
        if(isset($this->title)){
            return $this->title;
        }
        return 'No title';
    }
    /* bodyを取得
     * setBody
     * @param
     */
    public function setBody (){
        if(isset($this->body)){
            return $this->body;
        }
        return 'No body';
    }

    /* データ更新
     * UpdateTodo
     * @param
     *
     */
    private function updateTodo($param) {

        if(!isset($_POST['title']) || $_POST['title'] === '') {
            throw new \Exception('[update] title not set!');
        } else {
            $sql = sprintf("update t_todos set title = :title, body = :body, user_id = :user_id, user_name = :user_name, created = now()
            where todo_id = %d", $this->todo_id);
            $stmt = $this->_db->prepare($sql);
            $stmt->execute([
                ':title' => $this->title,
                ':body' => $this->body,
                ':user_id' =>$_SESSION['me']->id,
                ':user_name' =>$_SESSION['me']->user_name
            ]);
            header('Location:' . SITE_URL . '/master/todo.php');
        }
    }



}
