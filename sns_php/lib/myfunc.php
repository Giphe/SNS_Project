<?php
//myfunc的
namespace MyApp;

class myfunc {

    //パラメータを取得
    private $suFlg = 0;
    private $jimFlg = 0;

    //エスケープ関数
    public function h($s){
        return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    }

    //認証1:一般利用者、認証2：管理者
    public function myfunc($pageNo) {

        //stage=1
        $this->suFlg = $this->getSuFlg($login_id);
        if ($login_id = null || $password = null) {
        }

    }


    //管理者フラグ取得
    private function getSuFlg ($s_login, $s_group) {

        //SuFlgを取得
        $this->suFlg = \MyApp\Model\User()->select_Su($s_login);
    }

    //事務フラグ取得
    private function getJimFlg (){

    }
}