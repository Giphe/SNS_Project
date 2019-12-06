<?php
namespace MyApp;

class Fw {
    private $value;
    private $view;

    public function __construct(){

        if(!isset($_SESSION['token'])){
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }
        $this->view = new \stdClass();
        $this->value = new \stdClass();
    }

    protected function setValues($key, $value){
        $this->value->$key = $value;
        // var_dump($this->value);

    }

    public function getValues(){
        return $this->value;

    }
    protected function setErrors($key, $error){
        $this->view->$key = $error;
    }

    public function getErrors($key){
        return isset($this->view->$key) ?  $this->view->$key : '';

    }

}