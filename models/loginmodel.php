<?php

class LoginModel extends Model{
    function __construct(){
    }

    public function login(){
        parent::__construct();

        $link = $this->db->OpenConnection();
        $pass = $this->db->CheckLogin($_POST['username'], $_POST['password']);

        if( $pass ){
            Session::set('verified',true);
            $userinfo = $this->db->GetUserInfo($pass);
            Session::set('userinfo',$userinfo);
            $this->db->CloseConnection($link);
            header('location: '.URL.'dashboard');
        }else{
            $this->db->CloseConnection($link);
            header('location: '.URL.'login');
        }
    }
}