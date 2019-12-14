<?php
//myfunc的
namespace MyApp;

class myfunc {

    //パラメータを取得
    private $suFlg = 0;
    private $jimFlg = 0;
    private $login_id = '';

    //エスケープ関数
    public function h($s){
        return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    }

    //認証1:一般利用者、認証2：管理者
    public function checkUser($n_user) {

        //CSRF対策
        $this->_createToken();
        try{
            $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $e){
            echo $e->getMessage();
            exit;
        }

        $this->_validateToken();
        //セッションの値を格納
        $this->login_id = $_SESSION['me']->login_id;
        $this->password = $_SESSION['me']->password;

        //stage=1
        if ($n_user > 1) {
            $this->suFlg = $this->getSuFlg($this->login_id);
            $res = $this->suFlg;

            //管理者フラグ=0ならリダイレクト
            if ($res == 0) {
                header('Location: '. SITE_URL . '/master/index.php');
                exit;
            } else {
                return $res;
            }

        } else if ($n_user <= 1) {
            if ($this->login_id == '' || $this->password == '') {
                $this->suFlg = $this->getSuFlg($this->login_id);
                $res = $this->suFlg;
                return $res;
            }
        }
    }


    //管理者フラグ取得
    private function getSuFlg ($s_login, $s_group) {

        $user = MyApp\Model\User();
        //SuFlgを取得
        $this->suFlg = $user->select_Su($s_login);
    }

    //事務フラグ取得
    private function getJimFlg (){

    }

    /* _validateToken
     * @param
     */
    private function _validateToken() {
        if(!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']){
            throw new \Exception('invalid token!');
        }
        if(!isset($_SESSION['me']) && !isset($_POST['me'])){
            throw new \Exception('invalid me!');
        }
    }

    /* _createToken
     * @param
     * tokenを生成
     */
    private function _createToken(){
        if(!isset($_SESSION['token'])){
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }
    }
}