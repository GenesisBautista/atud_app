<?php

class Admin extends Controller{

    function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->loggedIn();
        $this->verifyAdmin();

        //remove later
        //print_r($_SESSION);

        $this->view->userlist = $this->model->grabuserlist();
        $this->view->render('admin/index');
        Session::remove('adminfunction');
    }

    public function edit($id){
        $this->loggedIn();
        $this->verifyAdmin();

        //remove later
        //print_r($_SESSION);

        $this->view->userinfo = $this->model->grabuser($id);
        $this->view->render('admin/edit');
    }

    public function runedit($id){
        $this->loggedIn();
        $this->verifyAdmin();

        $this->model->updateuser($id);
    }

    public function password($id){
        $this->loggedIn();
        $this->verifyAdmin();

        //remove later
        //print_r($_SESSION);

        $this->view->id = $id;
        $this->view->render('admin/password');
        Session::remove('adminfunction');
    }

    public function updatepassword($id){
        $this->loggedIn();
        $this->verifyAdmin();

        $this->model->changepassword($id);
    }

    public function createuser(){
        $this->loggedIn();
        $this->verifyAdmin();

        //remove later
        //print_r($_SESSION);

        $this->view->render('admin/createuser');
    }

    public function runcreateuser(){
        $this->loggedIn();
        $this->verifyAdmin();

        $this->model->createuser();
    }

    public function delete($id){
        $this->loggedIn();
        $this->verifyAdmin();

        $this->model->deleteuser($id);
    }
}