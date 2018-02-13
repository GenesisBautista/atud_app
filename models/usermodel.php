<?php

class UserModel extends Model{

    function __construct(){
        parent::__construct();
    }

    public function update(){
        $link = $this->db->OpenConnection();
        $this->db->UpdateUserInfo($_POST, $_SESSION['userinfo'][0]);
        $userinfo = $this->db->GetUserInfo($_SESSION['userinfo'][0]);
        Session::set('userinfo',$userinfo);
        $this->db->CloseConnection($link);
        header('location: '.URL.'user');
    }

    public function changepassword(){
        $link = $this->db->OpenConnection();
        $pass = $this->db->CheckLogin($_SESSION['userinfo'][1], $_POST['current']);
        if( !$pass ){
            $this->db->CloseConnection($link);
            //to do: error handling
            header('location: '.URL.'user/changepassword/wrongpass');
        }else if( $_POST['new'] != $_POST['verify'] ){
            $this->db->CloseConnection($link);
            //to do: error handling
            header('location: '.URL.'user/changepassword/noverify');
        }else{
            $this->db->UpdatePassword($_POST['new'], $_SESSION['userinfo'][0]);
            $this->db->CloseConnection($link);
            header('location: '.URL.'user/changepassword/complete');
        }
    }
}