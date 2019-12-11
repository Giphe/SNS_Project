<?php

namespace MyApp\Controller;

use Config\Common\UserConfig;

class Muser extends \MyApp\Controller{

    private $_db;
    protected $errMsg = [];
    protected $errFlg = '';
    protected $user = [];
    protected $filedir = UserConfig::FILEDIR;

    public function __construct(){
        try{
            $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $e){
            echo $e->getMessage();
            exit;
        }

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // ブラウザからHTMLページを要求された場合
            //エラーメッセージを表示

            //$_POST['user_name']の有無を確認
            if (isset($_POST['user_name'])) {
                $this->user['user_name'] = $_POST['user_name'];
            } else {
                $this->errMsg['level1'] = UserConfig::level1;
                $this->errFlg = UserConfig::ERRFLG;
            }

            //$_POST['mail']の有無を確認
            if (isset($_POST['email'])) {
                $this->user['email'] = $_POST['email'];
            } else {
                $this->errMsg['level2'] = UserConfig::level2;
                $this->errFlg = UserConfig::ERRFLG;
            }


            //$_POST['address']の有無を確認
            if (isset($_POST['address'])) {
                $this->user['address'] = $_POST['address'];
            } else {
                $this->errMsg['level4'] = UserConfig::level4;
                $this->errFlg = UserConfig::ERRFLG;
            }

            //$_POST['tel']の有無を確認
            if (isset($_POST['tel'])) {
                $this->user['tel'] = $_POST['tel'];
            } else {
                $this->errMsg['level5'] = UserConfig::level5;
                $this->errFlg = UserConfig::ERRFLG;
            }

            //$_POST['tel']の有無を確認
            if (isset($_POST['shokai'])) {
                $this->user['shokai'] = $_POST['shokai'];
            }

            //$_POST['icon']の有無を確認
            if (isset($_FILES['icon'])) {

                if (is_uploaded_file($_FILES["icon"]["tmp_name"])) {
                    if (move_uploaded_file($_FILES["icon"]["tmp_name"], __DIR__ . $this->filedir.$_FILES["icon"]["name"])) {
                        $this->user['icon'] = $_FILES["icon"]["name"];
                    }
                    else {
                        $this->user['icon'] = UserConfig::DEFAULTICON;
                    }
                }
                else {
                    $this->user['icon'] = UserConfig::DEFAULTICON;
                }
            } else {
                $this->user['icon'] = UserConfig::DEFAULTICON;
            }

            $this->user['premium_flg'] = $_POST['premium_flg'];
            $this->user['web_flg'] = $_POST['web_flg'];

            //DB更新
            if ($this->errFlg == UserConfig::ERRFLG) {
                return $this->errMsg;
                return $this->user;
                exit;
            } else {
                $this->update_user($this->user);
            }


        } else {
            return;
        }
    }

    /* viewに渡す validate
     * @param
     * postの値をviewに渡す
     */
    public function validate($values){
        $stmt = $this->db->prepare("select * from t_users where email = :email");
        $stmt->execute([
            ':email' => $values['email']
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        $user = $stmt->fetch();

        if(empty($user)){
            throw new \MyApp\Exception\UnmatchEmailOrPassword();
        }
        if(!password_verify($values['password'], $user->password)){
            throw new \MyApp\Exception\UnmatchEmailOrPassword();
        }
        return $user;
    }

    /* viewに渡す getValue
     * @param
     * postの値をviewに渡す
     */
    public function getValues(){
        $stmt = $this->_db->query("select * from t_users");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /* viewに渡す update_user
     * @param $user
     * postの値をviewに渡す
     */
    public function update_user($values){

        $this->_db->beginTransaction();

        $sql = sprintf("update t_users set email = :email, user_name = :user_name, address = :address,
        tel = :tel, shokai = :shokai, web_flg = :web_flg, premium_flg = :premium_flg, icon = :icon, modified = now(),
        modified_by = :modified_by where id = %d", $_SESSION['me']->id);
        $stmt = $this->_db->prepare($sql);
        $res = $stmt->execute([
            ':email' => $values['email'],
            ':user_name' => $values['user_name'],
            ':address' => $values['address'],
            ':tel' => $values['tel'],
            ':shokai' => $values['shokai'],
            ':web_flg' => $values['web_flg'],
            ':premium_flg' => $values['premium_flg'],
            ':icon' => $values['icon'],
            ':modified_by' => $_SESSION['me']->user_name
        ]);

        $this->_db->commit();

        if($res === false ){
            throw new \MyApp\Exception\DuplicateEmail();
        }
    }

    /* viewに渡す getUser
     * @param $
     * postの値をviewに渡す
     */
    public function getUser(){
        $stmt = $this->_db->query("select * from t_users");
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
    /* group検索 select_users_groupD
     * @param
     * postの値をviewに渡す
     */
    public function select_users_groupD(){
        if(!$this->isLoggedIn()){

        }
        //get users info
        $userModel = new \MyApp\Model\User();
        $this->setValues('user', $userModel->findAll());
    }

    //TODO:ログインチェック
    /* group検索 select_users_groupD
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
