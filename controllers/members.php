<?php

class Members extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->memberslist = $this->model->grabmembers(0, 0, 'empty');
        $this->view->render('members/index');
    }

    public function search($arr = '1:company:asc:0:0:empty'){
        $this->loggedIn();

        if( !empty($_POST) ){
            $this->model->sendsearch($_POST);
        }
        //remove later
        //print_r($_SESSION);
        $this->view->searchparam = $arr = explode(':', $arr);
        $searchvariables = $this->model->search($arr);
        $this->view->totalresults = $searchvariables[2];
        $this->view->pages = $searchvariables[1];
        $this->view->memberslist = $searchvariables[0];
        $this->view->companylist = $this->model->graballcompanies();
        $this->view->render('members/search');
        Session::remove('memberfunction');
    }

    public function create(){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->companylist = $this->model->graballcompanies();
        $this->view->render('members/create');
    }

    public function runcreate(){
        $this->loggedIn();

        $this->model->createmember();
    }

    public function deactivate($id){
        $this->loggedIn();

        $this->model->removemember($id);
    }

    public function reactivate($id){
        $this->loggedIn();

        $this->model->reactivatemember($id);
    }

    public function update($id){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->companylist = $this->model->graballcompanies();
        $this->view->memberinfo = $this->model->grabmemberinfo($id);
        $this->view->render('members/update');
    }

    public function runupdate(){
        $this->loggedIn();

        $this->model->updateuserinfo();
    }

    public function dues($id){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->memberdues = $this->model->grabduesbymember($id);
        $this->view->memberinfo = $this->model->grabmemberinfo($id);
        $this->view->render('members/dues/index');
    }

    public function removedues($arr){
        $this->loggedIn();

        $ids = $arr = explode(':', $arr);
        $this->model->removedues($ids[1], $ids[0]);
    }

    public function updatedues($arr){
        $this->loggedIn();

        $this->view->ids = $arr = explode(':', $arr);
        $this->view->duesinfo = $this->model->grabduesinfo($this->view->ids[1]);
        $this->view->render('members/dues/update');
    }

    public function runduesupdate(){
        $this->loggedIn();

        $this->model->updatedues($_POST);
    }

    public function duescreate($id){
        $this->loggedIn();

        $this->view->memberid = $id;
        $this->view->memberinfo = $this->model->grabmemberinfo($id);
        $this->view->render('members/dues/create');
    }

    public function runduescreate(){
        $this->loggedIn();

        $this->model->createdues($_POST);
    }
}
