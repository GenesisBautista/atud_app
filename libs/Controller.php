<?php

class Controller{

    public function __construct(){
        $this->view = new View();
    }

    public function loadModel($name){
        $file = 'models/'.$name.'model.php';
        if( file_exists($file) ){
            require $file;

            $modelName = $name.'Model';
            $this->model = new $modelName;
        }
    }

    public function loggedIn(){
        if( !empty($_SESSION['verified']) ){
            return true;
        }
        else{
            header('location: '.URL.'login');
        }
    }

    public function verifyAdmin(){
        if( $_SESSION['userinfo'][4] == 1 ){
            return true;
        }
        else{
            header('location: '.URL.'dashboard');
        }
    }
}
