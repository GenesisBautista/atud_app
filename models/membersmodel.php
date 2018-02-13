<?php

class MembersModel extends Model{
    function __construct(){
        parent::__construct();
    }

    public function search($arr){
        $search = Model::LoadModel("search", "members");
        $totalresults = $search->GetTotalResults(array($arr[3], $arr[4], $arr[5]));
        $result = $search->GetSearchResults($arr);
        $pagearray = $search->GeneratePageArray($arr[0], ceil($totalresults/50));
        return array( $result, $pagearray, $totalresults);
    }

    public function grabmembers($includeinactive, $company, $name){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabMembers(
            ($includeinactive == 0 ? 1 : "1 OR atud_members.active = 0 "),
            ($company == 0 ? NULL : $company),
            ($name == 'empty' ? NULL : $name)
        );
        $this->db->CloseConnection($link);
        Session::set('result', count($return));
        return $return;
    }

    public function grabmembersbyrange($includeinactive, $company, $name, $page, $sort, $sorttype){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabMembersByRange(
            ($includeinactive == 0 ? 1 : "1 OR atud_members.active = 0 "),
            ($company == 0 ? NULL : $company),
            ($name == 'empty' ? NULL : $name),
            $page,
            50,
            $sort,
            $sorttype
        );
        Session::set('resultcount', count($this->db->GrabMembers(
            ($includeinactive == 0 ? 1 : "1 OR atud_members.active = 0 "),
            ($company == 0 ? NULL : $company),
            ($name == 'empty' ? NULL : $name)
        )));
        $this->db->CloseConnection($link);
        Session::set('result', count($return));
        return $return;
    }

    public function graballcompanies(){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabAllCompanies();
        $this->db->CloseConnection($link);
        return $return;
    }

    public function grabduesbymember($id){
        $link = $this->db->OpenConnection();
        $return = $this->db->GetDuesByMember($id);
        $this->db->CloseConnection($link);
        return $return;
    }

    public function removedues($duesid, $memberid){
        $link = $this->db->OpenConnection();
        $this->db->RemoveDues($duesid);
        $this->db->CloseConnection($link);
        header('location: '.URL.'members/dues/'.$memberid);
        exit;
    }

    public function createmember(){
        $link = $this->db->OpenConnection();
        $this->db->CreateNewMembers($_POST['company'], $_POST['fname'], $_POST['lname'], $_POST['title'], $_POST['empid']);
        $this->db->CloseConnection($link);
        header('location: '.URL.'members');
        exit;
    }

    public function removemember($id){
        $link = $this->db->OpenConnection();
        $this->db->RemoveMember($id);
        $this->db->CloseConnection($link);
        header('location: '.URL.'members');
        exit;
    }

    public function grabmemberinfo($id){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabMemberInfo($id);
        $this->db->CloseConnection($link);
        return $return;
    }

    public function grabduesinfo($id){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabDuesByID($id);
        $this->db->CloseConnection($link);
        return $return;
    }

    public function updatedues($arr){
        $date = DateTime::createFromFormat( 'j F, Y', $arr['date'] );
        $link = $this->db->OpenConnection();
        $this->db->UpdateDues($arr['id'], $arr['paid'], $date->format('Y-m-d'));
        $this->db->CloseConnection($link);
        header('location: '.URL.'members/dues/'.$arr['memberid']);
        exit;
    }

    public function createdues($arr){
        $date = DateTime::createFromFormat( 'j F, Y', $arr['date'] );
        $link = $this->db->OpenConnection();
        $this->db->AddDues($arr['memberid'], $arr['companyid'], $date->format('Y-m-d'), $arr['paid']);
        $this->db->CloseConnection($link);
        header('location: '.URL.'members/dues/'.$arr['memberid']);
        exit;
    }

    public function updateuserinfo(){
        $link = $this->db->OpenConnection();
        $this->db->UpdateMember($_POST['id'], $_POST['company'], $_POST['fname'], $_POST['lname'], $_POST['title'], $_POST['empid'], $_POST['note']);
        $info = $this->db->GrabMemberInfo($_POST['id']);
        if( $_POST['status']==0 && $info['6']==1 ){
            $this->db->RemoveMember($_POST['id']);
        }
        else if( $_POST['status']==1 && $info['6']==0 ){
            $this->db->ReactivateMember($_POST['id']);
        }
        $this->db->CloseConnection($link);
        Session::set('memberfunction', $_POST['fname'].' '.$_POST['lname'].' Has been updated');
        header('location: '.URL.'members/update/'.$_POST['id']);
        exit;
    }

    public function reactivatemember($id){
        $link = $this->db->OpenConnection();
        $result = $this->db->ReactivateMember($id);
        if($result){
            Session::set('memberfunction', 'User has been reactivated');
        }
        else{
            Session::set('memberfunction', 'User has not been reactivated(this maybe due to their company being deactivated)');
        }
        $this->db->CloseConnection($link);
        header('location: '.URL.'members');
        exit;
    }

    public function sendsearch($post_arr){
        $search = Model::LoadModel("search", "members");
        $string = $search->GenerateURLString($post_arr);
        header('location: '.URL.'members/search/'.$string);
        exit;
    }
}
