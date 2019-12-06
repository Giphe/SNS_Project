<?php

namespace MyApp\Controller;

class Topics extends \MyApp\Controller{

    protected $user_name = '';

    public function __construct(){
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



    /* viewに渡す getValue
     * @param
     * postの値をviewに渡す
     */
    public function getValues(){
        $stmt = $this->_db->query("select * from t_topics");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /*
     * getCategory
     * @param
     * カテゴリ表示用
     */
    public function getCategory(){
        $stmt = $this->_db->query("select * from m_category");
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
