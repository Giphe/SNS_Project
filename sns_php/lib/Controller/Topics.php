<?php

namespace MyApp\Controller;

// try{
//     $_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
//     $_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
// }catch(\PDOException $e){
//     echo $e->getMessage();
//     exit;
// }

class Topics extends \MyApp\Controller {

    protected $user_name = '';
    protected $_db = '';


    public function __construct(){

        //認証チェック
        $myfunc = new \MyApp\myfunc();
        $myfunc->checkUser(1);

        if($_SERVER["REQUEST_METHOD"] != "POST"){
            // ブラウザからHTMLページを要求された場合
            if ($this->user_name != '') {
                $this->user_name = $_SESSION['me']->user_name;
            }
            //セッション変数のuser_nameの値をそのまま渡す
        }
    }



    /* viewに渡す getValue
     * @param
     * postの値をviewに渡す
     */
    public function getValues(){
    	$_db = $this->db();
        $stmt = $_db->query("select * from t_topics");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /*
     * getCategory
     * @param
     * カテゴリ表示用
     */
    public function getCategory(){
    	$_db = $this->db();
        $stmt = $_db->query("select * from m_category");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /* 検索値を返すgetResearch
     * @param
     * postの値をviewに渡す
     */
    public function getResearch(){
        if(!$this->isLoggedIn()){
            return 'user_name';
        }
    }


    /* viewに渡す setSidebar
     * @param
     * Sidebarの表示
     */
    public function setSidebar(){
        if(!$this->isLoggedIn()){
            return 'Sidebar';
        }

    }

    //TODO:ポストの値
    /* group検索 select_topics_groupD
     * @param
     * postの値をviewに渡す
     */
    public function select_topics_groupD(){
        if(!$this->isLoggedIn()){

        }
        //get users info
        $topicsModel = new \MyApp\Model\Topics();
        $this->setValues('topics', $topicsModel->findAll());
    }

    //TODO:ログインチェック
    /* group検索 select_topics_groupD
     * @param
     * postの値をviewに渡す
     */
    protected function isLoggedIn(){
        //$_SESSION['me']
        return isset($_SESSION['me']) && !empty($_SESSION['me']);
    }

    public function me(){
        return $this->isLoggedIn() ? $_SESSION['me'] : null;
    }

}
