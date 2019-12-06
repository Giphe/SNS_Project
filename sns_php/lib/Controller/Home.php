<?php

namespace MyApp\Controller;

class Home extends \MyApp\Controller{

    public function run(){
        if(!$this->isLoggedIn()){
            //login
            header('Location: '. bathPath . '/home.php');
            exit;
        }
        //get users info
        $userModel = new \MyApp\Model\User();
        $this->setValues('users', $userModel->findAll());
    }
}
