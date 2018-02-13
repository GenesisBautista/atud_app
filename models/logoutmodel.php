<?php

class LogoutModel extends Model{
    function __construct(){
    }

    public function logout(){
        parent::__construct();

        Session::kill();
        header('location: '.URL.'login');
    }
}