<?php

//CSRF対策
//コントローラーを読み込んでから,indexacionでindexを呼び出す仕組み

namespace MyApp\Controller;

class Comment extends \MyApp\Controller {

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

        //認証チェック
        $myfunc = new \MyApp\myfunc();
        $myfunc->checkUser(1);

        //セッションの値を格納
        $this->user_name = $_SESSION['me']->user_name;


        if($_SERVER["REQUEST_METHOD"] != "POST"){
            // ブラウザからHTMLページを要求された場合
            if ($this->user_name != '') {
                $this->user_name = $_SESSION['me']->user_name;
            }
            //セッション変数のuser_nameの値をそのまま渡す

        }else{

            //ポストされた値を格納
            $this->todo_id = $_REQUEST['todo_id'];
            $this->user_name = $_POST['user_name'];
            $this->body = $_POST['body'];

            try {

                if (isset($this->user_name)) {
                    if (isset($this->body)) { // $this->body == null
                        $this->createComment($this->todo_id);
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
     * _validateToken
     * @param
     */
     /*
    private function _validateToken(){
        if(!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']){
            throw new \Exception('invalid token!');
        }
        if(!isset($_SESSION['me']) && !isset($_POST['me'])){
            throw new \Exception('invalid me!');
        }
    }
    */

    /*user_nameを表示
     * setUsernm
     * @param
     *
     */
    public function setUsernm() {
        return $this->user_name; //$_SESSION['me']->user_name;
    }

    /* comment新規作成
     * createComment
     * @param
     * @return array();
     */
    private function createComment($param){
        //         $user_id = $_SESSION[me]->id;
        //         $user_name = $_SESSION[me]->user_name;

        if(!isset($_POST['user_name']) || $_POST['user_name'] === '') {
            throw new \Exception('[create] user_name not set!');
        } else {
            $sql = "insert into t_comments (todo_id, body, user_id, user_name, created)
            values (:todo_id, :body, :user_id, :user_name, now())";
            $stmt = $this->_db->prepare($sql);
            $stmt->execute([
                ':todo_id' => $param,
                ':body' => $_POST['body'],
                ':user_id' =>$_SESSION['me']->id,
                ':user_name' =>$this->user_name
            ]);
            header('Location:' . SITE_URL . '/master/todo.php');
        }

    }


}
