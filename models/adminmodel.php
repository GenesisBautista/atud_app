<?php

class AdminModel extends Model{

    function __construct(){
        parent::__construct();
    }

    public function grabuserlist(){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabAllUsers();
        $this->db->CloseConnection($link);
        return $return;
    }

    public function grabuser($id){
        $link = $this->db->OpenConnection();
        $return = $this->db->GetUserInfo($id);
        $this->db->CloseConnection($link);
        return $return;
    }

    public function updateuser($id){
        $link = $this->db->OpenConnection();
        $this->db->UpdateUserInfo($_POST, $id);
        $this->db->CloseConnection($link);
        Session::set('adminfunction', 'User Updated');
        header('location: '.URL.'admin');
    }

    public function changepassword($id){
        $link = $this->db->OpenConnection();
        if( $_POST['new'] != $_POST['verify'] ){
            $this->db->CloseConnection($link);
            //to do: error handling
            Session::set('adminfunction', 'Passwords mismatch');
            header('location: '.URL.'admin/password/'.$id);
        }else{
            $this->db->UpdatePassword($_POST['new'], $id);
            $this->db->CloseConnection($link);
            Session::set('adminfunction', 'Password Changed');
            header('location: '.URL.'admin');
        }
    }

    public function createuser(){
        $link = $this->db->OpenConnection();
        if( $_POST['verify'] != $_POST['password'] ){
            $this->db->CloseConnection($link);
            //to do: error handling
            Session::set('adminfunction', 'Passwords mismatch');
            header('location: '.URL.'admin');
        }else{
            $this->db->CreateUser($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password'], $_POST['type']);
            $this->db->CloseConnection($link);
            Session::set('adminfunction', 'User Created');
            header('location: '.URL.'admin');
        }
    }

    public function deleteuser($id){
        $link = $this->db->OpenConnection();
        $this->db->RemoveUser($id);
        $this->db->CloseConnection($link);
        Session::set('adminfunction', 'User Removed');
        header('location: '.URL.'admin');
    }
}