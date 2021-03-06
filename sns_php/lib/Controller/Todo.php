<?php

//CSRF対策
//コントローラーを読み込んでから,indexacionでindexを呼び出す仕組み


namespace MyApp\Controller;

class Todo extends \MyApp\Controller {

    //パラメータを取得
    private $_db;
    protected $user_id;
    protected $user_name;
    protected $value;
    protected $todo_id;
    protected $title;
    protected $body;
    protected $parameter;


    public function indexAction () {
        //パラメータを取得
        $state = 1;

        //取得したパラメータをviewにセット
        $this->view->set('state', $state);
    }

    public function __construct(){
        $this->_createToken();
        try{
            $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $e){
            echo $e->getMessage();
            exit;
        }

        if($_SERVER["REQUEST_METHOD"] != "POST"){
            // ブラウザからHTMLページを要求された場合
            if ($this->user_name != '') {
                $this->user_name = $_SESSION['me']->user_name;
            }
            //セッション変数のuser_nameの値をそのまま渡す

        }
    }

    private function _createToken(){
        if(!isset($_SESSION['token'])){
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }
    }

    /*
     * getAll
     * @param
     * todo項目をすべて取得,todo_idをwhere句にセット
     */
    public function getAll(){
        $stmt = $this->_db->query("select * from t_todos order by todo_id desc");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /*
     * getAllComments
     * @param todo_id
     * コメントをすべて取得、todo_idを取得しなければ意味なし
     */
    public function getAllComments($param){
        $stmt = $this->_db->query(sprintf("select * from t_comments where todo_id = %d order by comment_id asc", $param));
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    public function post(){
        $this->_validateToken();
        if(!isset($_POST['mode'])){
            throw new \Exception('mode not set!');
        }

        switch($_POST['mode']){
            case 'update':
                return $this->_update();
            case 'create':
                return $this->_create();
            case 'delete':
                return $this->_delete();
            case 'update_all':
                return $this->_update_all();
            case 'all_delete':
                return $this->_delete_all();
            case 'mole_delete':
                return $this->_delete_mole();
//             case 'logout':
//                 return $this->_logout();

        }
    }

    /*
     * _validateToken
     * @param
     *
     */
    private function _validateToken(){
        if(
            !isset($_SESSION['token']) ||
            !isset($_POST['token']) ||
            $_SESSION['token'] !== $_POST['token']
            ){
                throw new \Exception('invalid token!');
        }
    }

    /*
     * _update
     * @param
     * @return array();
     */
    private function _update(){
        if(!isset($_POST['id'])){
            throw new \Exception('[update] todo_id not set!');
        }

        $this->_db->beginTransaction();

        $sql = sprintf("update t_todos set state = (state + 1) %% 2 where todo_id = %d", $_POST['id']);
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        $sql = sprintf("select state from t_todos where todo_id = %d",$_POST['id']);
        $stmt = $this->_db->query($sql);
        $state = $stmt->fetchColumn();

        $this->_db->commit();

        return [
            'state' => $state
        ];
    }

    /*全体更新
     * _update_all
     * @param
     *
     */
    private function _update_all() {
        if(!isset($_POST['id'])){
            throw new \Exception('[update] id not set!');
        }

        $this->_db->beginTransaction();

        $sql = sprintf("update t_todos set state = %d %% 2", $_POST['id']);
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        $this->_db->commit();

        return [];
    }

    /*todo新規作成
     * _create
     * @param
     *
     */
    private function _create(){
        //         $user_id = $_SESSION[me]->id;
        //         $user_name = $_SESSION[me]->user_name;

        if(!isset($_POST['title']) || $_POST['title'] === '') {
            throw new \Exception('[create] title not set!');
        } else {
            $sql = "insert into t_todos (title, body, user_id, user_name, created)
            values (:title, :body, :user_id, :user_name, now())";
            $stmt = $this->_db->prepare($sql);
            $stmt->execute([
                ':title' => $_POST['title'],
                ':body' => $_POST['body'],
                ':user_id' =>$_SESSION['me']->id,
                ':user_name' =>$_SESSION['me']->user_name
            ]);
            return [
                'todo_id' => $this->_db->lastInsertId()
            ];
        }

    }

    /*単一物理削除
     * _create
     * @param
     *
     */
    private function _delete() {
        if(!isset($_POST['id'])){
            throw new \Exception('[delete] todo_id not set!');
        }
        $sql = sprintf("delete from t_todos where todo_id = %d", $_POST['id']);
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        $sql = sprintf("delete from t_comments where todo_id = %d", $_POST['id']);
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        return [];
    }

    /*全体物理削除
     * _delete_all
     * @param
     *
     */
    private function _delete_all() {
        if(!isset($_POST['check'])){
            throw new \Exception('[all_delete] check not set!');
        }

        if ($_POST['check'] == "true") {
            $sql = "truncate table t_todos";
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();

            $sql = "truncate table t_comments";
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
        } else {
            return [];
        }
        return [];
    }

    /* 一括物理削除
     * _delete_mole
     * @param
     *
     */
    private function _delete_mole() {
        if(!isset($_POST['check'])){
            throw new \Exception('[_mole_delete]  not set!');
        }
        if ($_POST['check'] == "false") {
            $sql = "delete from t_todos where state = 1";
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();

            $sql = "delete from t_comments where state = 1";
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
        }
        return [];
    }

    /*ログアウト
     * _logout
     * @param null
     *
     */
//     private function _logout() {

//         if ($_POST['token'] != null) {
//             header('Location:' . SITE_URL . '/master/logout.php');
//             exit;
//         }
//         header('Location:' . SITE_URL . '/master/logout.php');
//         exit;
//     }

}

?>
