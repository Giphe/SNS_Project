<?php

namespace MyApp\Controller;

class Index extends \MyApp\Controller {

    //パラメータを取得
    protected $user_name = '';

  public function run() {
    if(!$this->isLoggedIn()){
    //login
    header('Location: '. SITE_URL . '/master/login.php');
    exit;
    }
    //get users info
    $userModel = new \MyApp\Model\User();
    $this->setValues('user', $userModel->selectUser());

    $follow_info = new \MyApp\Model\Follow();
    $this->setValues('follow', $follow_info->get_follow());
    $this->setValues('follower', $follow_info->get_follower());
  }


  public function __construct() {
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

  /*
   * post
   * @param null
   * タブ、いいね、フォローのajax処理
   */
  public function post(){
      $this->_validateToken();
      if(!isset($_POST['mode'])){
          throw new \Exception('mode not set!');
      }

      switch($_POST['mode']){
          case 'follow':
              return $this->follow();
          case 'good':
              return $this->_good();
          case 'delete':
              return $this->_delete();


      }
  }
}
