<?php

namespace MyApp\Controller;

class Index extends \MyApp\Controller {

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
      //パラメータの取得
      //post処理
  }
}
