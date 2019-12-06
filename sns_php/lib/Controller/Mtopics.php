<?php

namespace MyApp\Controller;

class Mtopics extends \MyApp\Controller{

    protected $user_name = '';
    protected $_topic = array(
        'kubun' => '',
        'category_id' => '',
        'title' => '',
        'body' => '',
        'koukai_date' => '',
        'start_date' => '',
        'end_date' => '',
        'created_by' => '',
        'modified_by' => ''
    );

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
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // ブラウザからHTMLページを要求された場合
            if ($this->user_name != '') {
                try {
                    $this->_topic['title'] = $_POST['title'];
                    $this->_topic['body'] = $_POST['body'];
                    $this->_topic['kubun'] = $_POST['kubun'];
                    $this->_topic['category_id'] = $_POST['category_id'];
                    $this->_topic['koukai_date'] = $_POST['koukai_date'];
                    $this->_topic['start_date'] = $_POST['start_date'];
                    $this->_topic['end_date'] = $_POST['end_date'];
                    $this->_topic['user_name'] = $_SESSION['me']->user_name;

                } catch(\Exception $e) {
                    header('Location:' . SITE_URL . '/master/topics.php');
                    exit;
                }

                if(isset($this->_topic) || $this->_topic == "") {
                    $this->createTopics($this->_topic);
                }

            }
            //セッション変数のuser_nameの値をそのまま渡す
            return;

        }else{
            // フォームからPOSTによって要求された場合
            $this->_validateToken();

            try {



            }catch (\MyApp\Exception\InvalidEmail $e) {
                $this->setErrors('user_name', $e->getMessage());
            }

        }
        return;
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
        $stmt = $this->_db->query("select * from m_category order by category_id asc");
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
     */
    private function _validateToken(){
//         if(!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']){
//             throw new \Exception('invalid token!');
//         }
        if(!isset($_SESSION['me']) && !isset($_POST['me'])){
            throw new \Exception('invalid me!');
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

    /* topics新規作成
     * createComment
     * @param
     * @return array();
     */
    private function createTopics($param){
        if(isset($param['body']) || $param['body'] == "") {
            try{
                    $sql = "insert into t_topics (kubun, category_id, title, body, koukai_date, start_date, end_date, created, created_by, modified, modified_by)
                    values (:kubun, :category_id, :title, :body, :koukai_date, :start_date, :end_date, now(), :created_by, now(), :modified_by)";
                    $stmt = $this->_db->prepare($sql);
                    $stmt->execute([
                        ':kubun' => $param['kubun'],
                        ':category_id' => $param['category_id'],
                        ':title' => $param['title'],
                        ':body' => $param['body'],
                        ':koukai_date' => $param['koukai_date'],
                        ':start_date' => $param['start_date'],
                        ':end_date' => $param['end_date'],
                        ':created_by' => $param['user_name'],
                        ':modified_by' => $param['user_name']

                    ]);
                    $this->_db->commit();
                } catch(\Exception $e) {
                    return;
                }
            header('Location:' . SITE_URL . '/master/topics.php');
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
