<?php

class Import extends Controller
{
    function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->verifier = $this->model->setverifier(time());
        $this->view->companylist = $this->model->getcompanies();
        $this->view->render('import/index');
        Session::remove('importmessage');
        Session::remove('usedids');
        Session::remove('delinquentdate');
    }

    public function run(){
        $this->loggedIn();

        $this->model->run();
    }

    public function flags(){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->flaggedmemberinfo = Session::get('flaggedmemberinfo');
        $this->view->currentmembers = $this->model->getmembers(Session::get('company_id'));
        $this->view->render('import/flags');
        Session::remove('flaggedmemberinfo');
    }

    public function runflags(){
        $this->loggedIn();

        $this->model->runflags();
    }

    public function delinquent(){
        $this->loggedIn();

        //remove later
        //print_r($_SESSION);

        $this->view->delinquentdate = Session::get('delinquentdate');
        $this->view->delinquentmem = $this->model->getdelinquents();
        $this->view->render('import/delinquent');
        Session::remove('delinquentdate');
    }

    public function rundelinquents(){
        $this->loggedIn();

        $this->model->rundelinquents();
    }
}
