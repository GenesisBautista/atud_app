<?php

class Index extends Controller{

    function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->loggedIn();
        $this->view->render('index/index');
    }
}