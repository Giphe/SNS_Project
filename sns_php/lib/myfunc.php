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
    public function myfunc($n_user) {
        $res = '';

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
}