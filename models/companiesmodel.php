<?php

class CompaniesModel extends Model{

    function __construct(){
        parent::__construct();
    }

    public function grabcompanylist(){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabAllCompanies();
        $this->db->CloseConnection($link);
        return $return;
    }

    public function createcompany(){
        $link = $this->db->OpenConnection();
        $this->db->CreateCompany($_POST['name']);
        $this->db->CloseConnection($link);
        header('location: '.URL.'companies');
        exit;
    }

    public function grabcompanyinfo($id){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabCompanyInfo($id);
        $this->db->CloseConnection($link);
        return $return;
    }

    public function updatecompany(){
        $link = $this->db->OpenConnection();
        $this->db->UpdateCompanyInfo($_POST['id'], $_POST['name']);
        $info = $this->db->GrabCompanyInfo($_POST['id']);
        if( $info['2'] == 1 && $_POST['active'] == 0 ){
            header('location: '.URL.'companies/deactivate/'.$_POST['id']);
            exit;
        }
        else if( $info['2'] == 0 && $_POST['active'] == 1 ){
            $this->db->ReactivateCompany($_POST['id']);
        }
        $this->db->CloseConnection($link);
        header('location: '.URL.'companies');
        exit;
    }

    public function deactivatecompany($id){
        $link = $this->db->OpenConnection();
        $memberslist = $this->db->GrabMembers(1, $id, NULL);
        foreach($memberslist as $members){
            $this->db->RemoveMember($members['id']);
        }
        $this->db->DeactivateCompany($id);
        $this->db->CloseConnection($link);
        header('location: '.URL.'companies');
        exit;
    }

    public function grabcompanymembers($id){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabMembers(1, $id, NULL);
        $this->db->CloseConnection($link);
        return $return;
    }

    public function reactivatecompany($id){
        $link = $this->db->OpenConnection();
        $this->db->ReactivateCompany($id);
        $this->db->CloseConnection($link);
        header('location: '.URL.'companies');
        exit;
    }
}
