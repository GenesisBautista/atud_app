<?php

class Dashboard extends Controller{

    function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->render('dashboard/index');
    }
}