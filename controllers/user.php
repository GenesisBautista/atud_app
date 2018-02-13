<?php

class User extends Controller{

    function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->render('user/index');
    }

    public function changepassword($msg = null){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->msg = $msg;
        $this->view->render('user/changepassword');
    }

    public function updatepassword(){
        $this->model->changepassword();
    }


    public function update(){
        $this->model->update();
    }
}
