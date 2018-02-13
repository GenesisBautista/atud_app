<?php

class Companies extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->companylist = $this->model->grabcompanylist();
        $this->view->render('companies/index');
    }

    public function create(){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->render('companies/create');
    }

    public function runcreate(){
        $this->loggedIn();
        $this->model->createcompany();
    }

    public function update($id){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->companyinfo = $this->model->grabcompanyinfo($id);
        $this->view->render('companies/update');
    }

    public function runupdate(){
        $this->loggedIn();

        $this->model->updatecompany();
    }

    public function deactivate($id){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->memberslist = $this->model->grabcompanymembers($id);
        $this->view->id = $id;
        $this->view->render('companies/deactivate');
    }

    public function rundeactivate($id){
        $this->loggedIn();

        $this->model->deactivatecompany($id);
    }

    public function reactivate($id){
        $this->loggedIn();

        $this->model->reactivatecompany($id);
    }
}
