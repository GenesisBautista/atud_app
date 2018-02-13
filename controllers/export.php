<?php

class Export extends Controller{
    function  __construct(){
        parent::__construct();

    }

    public function index(){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->render('export/index');
    }

    public function memberreport(){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->companylist = $this->model->graballcompanies();
        $this->view->memberslist = $this->model->grabmembers(
            ( $_POST['active'] ) ? "1 OR atud_members.active = 0 " : 1,
            ( !empty($_POST['company']) ) ? $_POST['company'] : NULL,
            ( !empty($_POST['name']) ) ? $_POST['name'] : NULL);

        $this->view->render('export/memberreport');
    }

    public function generatememberreport($id){
        $this->loggedIn();

        $this->model->generatememberreport($id);
    }

    public function generatecompanyreports($id){
        $this->loggedIn();

        $this->model->generatecompanyreports($id);
    }

    public function companyreports(){
        $this->loggedIn();

        $this->view->companylist = $this->model->graballcompanies();
        $this->view->render('export/companyreports');
    }

    public function fullreport(){
        $this->loggedIn();

        $this->model->fullreport();
    }
}