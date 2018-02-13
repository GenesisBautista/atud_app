<?php

class Login extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function index(){

        //remove later
        //print_r($_SESSION);

        $this->view->render('login/index');
    }

    function run(){
        $this->model->login();
    }
}