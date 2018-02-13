<?php

class Database{

    //DATABASE NEEDS
    public function OpenConnection(){
        $db = require 'config/db.php';

        $link = mysql_connect($db->host, $db->username, $db->password );

        if(!$link){
            die('Could not connect to the host: '.mysql_error());
        }
        mysql_select_db($db->database, $link);
        return $link;
    }

    public function CloseConnection($link){
        mysql_close($link);
    }

    public function Query($qry){
        if( $result = mysql_query($qry) ){
            $i=0;
            while( $row = mysql_fetch_assoc($result) ){
                $returned[$i] = $row;
                $i++;
            }
            mysql_free_result($result);
            return $returned;
        }
        else{
            return false;
        }
    }

    //Login Functions
    public function CheckLogin($email, $password){
        $qry = "SELECT id FROM atud_users WHERE email = '".mysql_real_escape_string($email)."' AND password = SHA2('".mysql_real_escape_string($password)."', 512)";
        $result = mysql_query($qry);
        $returned = mysql_fetch_row($result);
        if( mysql_num_rows($result) === 1 ){
            mysql_free_result($result);
            return $returned[0];
        }
        else{
            mysql_free_result($result);
            return false;
        }
    }

    //User/Admin Functions
    public function GetUserInfo($id){
        $qry = "SELECT id, email, firstName, lastName, type  FROM atud_users WHERE id = ".$id;
        $result = mysql_query($qry);
        $returned = mysql_fetch_row($result);
        mysql_free_result($result);
        return $returned;
    }

    public function UpdateUserInfo($userinfo, $id){
        $qry = "UPDATE
                    `atud_ledger`.`atud_users`
                SET
                    `email`='".mysql_real_escape_string($userinfo['email'])."',
                    `firstName`='".mysql_real_escape_string($userinfo['fname'])."',
                    `lastName`='".mysql_real_escape_string($userinfo['lname'])."',
                    `type`=".mysql_real_escape_string($userinfo['type'])."
                WHERE
                    `id`='".$id."'";
        mysql_query($qry);
    }

    public function UpdatePassword($password, $id){
        $qry = "UPDATE `atud_ledger`.`atud_users` SET `password`=SHA2('".mysql_real_escape_string($password)."', 512) WHERE `id`='".mysql_real_escape_string($id)."'";
        mysql_query($qry);
    }

    public function GrabAllUsers(){
        $qry = "SELECT id, email, firstName, lastName, type  FROM atud_users";
        $result = mysql_query($qry);
        $returned = array();
        $i = 0;
        while( $row = mysql_fetch_assoc($result) ){
            $returned[$i] = $row;
            $i++;
        }
        mysql_free_result($result);
        return $returned;
    }

    public function CreateUser($fname, $lname, $email, $password, $type){
        $qry = "INSERT INTO `atud_ledger`.`atud_users` (`email`, `firstName`, `lastName`, `password`, `type`)
                VALUES ('".$email."', '".$fname."', '".$lname."', SHA2('".$password."', 512), '".$type."');";
        mysql_query($qry);
    }

    public function RemoveUser($id){
        $qry = "DELETE FROM `atud_ledger`.`atud_users` WHERE `id`='".$id."';";
        mysql_query($qry);
    }

    //Company Functions
    public function GrabAllCompanies(){
        $qry = "SELECT * FROM atud_companies;";
        $result = mysql_query($qry);
        $returned = array();
        $i = 0;
        while( $row = mysql_fetch_assoc($result) ){
            $returned[$i] = $row;
            $i++;
        }
        mysql_free_result($result);
        return $returned;
    }

    public function GrabActiveCompanies(){
        $qry = "SELECT * FROM atud_companies WHERE active=1;";
        $result = mysql_query($qry);
        $returned = array();
        $i = 0;
        while( $row = mysql_fetch_assoc($result) ){
            $returned[$i] = $row;
            $i++;
        }
        mysql_free_result($result);
        return $returned;
    }

    public function GrabImportCompany(){
        $qry = "SELECT * FROM atud_companies WHERE active=1 AND import=1;";
        $result = mysql_query($qry);
        $returned = array();
        $i = 0;
        while( $row = mysql_fetch_assoc($result) ){
            $returned[$i] = $row;
            $i++;
        }
        mysql_free_result($result);
        return $returned;
    }

    public function CreateCompany($name){
        $name = mysql_real_escape_string($name);
        $qry = "INSERT INTO `atud_ledger`.`atud_companies` (`name`) VALUES ('".$name."')";
        mysql_query($qry);
    }

    public function RemoveCompany($id){
        $id = mysql_real_escape_string($id);
        $qry ="DELETE FROM `atud_ledger`.`atud_companies` WHERE `id`='".$id."'";
        mysql_query($qry);
    }

    public function GrabCompanyInfo($id){
        $id = mysql_real_escape_string($id);
        $qry = "SELECT * FROM `atud_ledger`.`atud_companies` WHERE `id`='".$id."'";
        $result = mysql_query($qry);
        $returned = mysql_fetch_row($result);
        mysql_free_result($result);
        return $returned;
    }

    public function UpdateCompanyInfo($id, $name){
        $id = mysql_real_escape_string($id);
        $name = mysql_real_escape_string($name);
        $qry = "UPDATE `atud_ledger`.`atud_companies` SET `name`='".$name."' WHERE `id`='".$id."'";
        mysql_query($qry);
    }

    public function DeactivateCompany($id){
        $id = mysql_real_escape_string($id);
        $qry = "UPDATE `atud_ledger`.`atud_companies` SET `active`='0', `inactivedate`=NOW() WHERE `id`='".$id."'";
        mysql_query($qry);
    }

    public function ReactivateCompany($id){
        $id = mysql_real_escape_string($id);
        $qry = "UPDATE `atud_ledger`.`atud_companies` SET `active`='1', `inactivedate`=NULL WHERE `id`='".$id."'";
        mysql_query($qry);
    }

    //Members Functions
    public function GrabMembers($activeonly, $company, $name){
        $qry = "SELECT atud_members.id, atud_companies.name AS company, firstname, lastname, title, company_id, atud_members.active
                FROM  `atud_members`
                INNER JOIN  `atud_companies` ON  `atud_companies`.id =  `atud_members`.company_fk
                WHERE (atud_members.active = ".$activeonly.")";
        if( !empty($company) ){
            $qry .= " AND atud_members.company_fk = ".$company;
        }
        if( !empty($name) ){
            $qry .= " AND CONCAT(atud_members.firstname, ' ', atud_members.lastname) LIKE '%".mysql_real_escape_string($name)."%'";
        }
        $result = mysql_query($qry);
        $returned = array();
        $i = 0;
        while( $row = mysql_fetch_assoc($result) ){
            $returned[$i] = $row;
            $i++;
        }
        mysql_free_result($result);
        return $returned;
    }

    public function GrabMembersByRange($activeonly, $company, $name, $page, $rows, $sort, $sorttype){
        $start = ($page - 1) * $rows;
        $qry = "SELECT atud_members.id, atud_companies.name AS company, CONCAT_WS(' ', firstname, lastname) as name, title, company_id, atud_members.active as status
                FROM  `atud_members`
                INNER JOIN  `atud_companies` ON  `atud_companies`.id =  `atud_members`.company_fk
                WHERE (atud_members.active = ".$activeonly.")";
        if( !empty($company) ){
            $qry .= " AND atud_members.company_fk = ".$company;
        }
        if( !empty($name) ){
            $qry .= " HAVING name LIKE '%".mysql_real_escape_string($name)."%'";
        }
        $qry .= " ORDER BY ".$sort." ".$sorttype;
        if( !empty($page) ){
            $qry .= " LIMIT ".$start.", ".$rows;
        }
        $result = mysql_query($qry);
        $returned = array();
        $i = 0;
        while( $row = mysql_fetch_assoc($result) ){
            $returned[$i] = $row;
            $i++;
        }
        mysql_free_result($result);
        return $returned;
    }

    public function GetMembersByCompany($company){
        $qry = "SELECT atud_members.company_id as employee_id, atud_companies.name as company_name, atud_members.firstname as member_fname, atud_members.lastname as member_lname, atud_members.id as db_mem_id
                FROM atud_members
                INNER JOIN atud_companies ON atud_members.company_fk = atud_companies.id
                WHERE atud_companies.id =".$company." AND atud_members.active = 1";
        if( $result = mysql_query($qry) ){
            $i=0;
            while( $row = mysql_fetch_assoc($result) ){
                $returned[$i] = $row;
                $i++;
            }
            mysql_free_result($result);
            return $returned;
        }
        else{
            return false;
        }
    }

    public function GrabMemberInfo($id){
        $qry = "SELECT * FROM atud_ledger.atud_members WHERE id=".$id;
        $result = mysql_query($qry);
        $returned = mysql_fetch_row($result);
        mysql_free_result($result);
        return $returned;
    }

    public function GrabMemberInfoByCompanyID($id, $company){
        $qry = "SELECT * FROM atud_ledger.atud_members WHERE company_id=".$id." AND company_fk = ".$company;
        if ( $result = mysql_query($qry) ){
            $returned = mysql_fetch_row($result);
            mysql_free_result($result);
            return $returned;
        }
        else{
            return false;
        }
    }

    public function CreateNewMembers($company, $fname, $lname, $title, $company_id){
        $fname = mysql_real_escape_string($fname);
        $lname = mysql_real_escape_string($lname);
        $title = mysql_real_escape_string($title);
        $qry = "INSERT INTO `atud_ledger`.`atud_members` (`company_fk`, `firstname`, `lastname`, `title`, `company_id`, `active`)
                VALUES ('".$company."', '".$fname."', '".$lname."', '".$title."', '".$company_id."', '1');";
        mysql_query($qry);
    }

    public function RemoveMember($id){
        $qry = "UPDATE `atud_ledger`.`atud_members` SET `active`='0', `inactivedate`=NOW() WHERE `id`='".$id."';";
        mysql_query($qry);
    }

    public function ReactivateMember($id){
        $qry = "SELECT `atud_companies`.active FROM `atud_companies` INNER JOIN `atud_members` ON `atud_companies`.id = `atud_members`.company_fk WHERE `atud_members`.id = ".$id;
        $result = mysql_query($qry);
        $companystatus = mysql_fetch_row($result);
        mysql_free_result($result);
        if( $companystatus['0']){
            $qry = "UPDATE `atud_ledger`.`atud_members` SET `active`='1', `inactivedate`=NULL WHERE `id`='".$id."'";
            mysql_query($qry);
            return true;
        }
        else{
            return false;
        }
    }

    public function UpdateMember($id, $company, $fname, $lname, $title, $company_id, $note){
        $fname = mysql_real_escape_string($fname);
        $lname = mysql_real_escape_string($lname);
        $title = mysql_real_escape_string($title);
        $company_id = mysql_real_escape_string($company_id);
        $note = mysql_real_escape_string($note);
        $qry = "UPDATE
                  `atud_ledger`.`atud_members`
                SET
                  `company_fk`='".$company."',
                  `firstname`='".$fname."',
                  `lastname`='".$lname."',
                  `title`='".$title."',
                  `company_id`='".$company_id."',
                  `note`='".$note."'
                WHERE
                  `id`='".$id."'";
        mysql_query($qry);
    }

    public function GetDelinquents($usedids, $company){
        $list = join( ', ', $usedids );
        $qry = "SELECT * FROM atud_ledger.atud_members WHERE id NOT IN( ".$list." ) AND company_fk = ".$company." AND active = 1";
        $result = mysql_query($qry);
        $returned = array();
        $i = 0;
        while( $row = mysql_fetch_assoc($result) ){
            $returned[$i] = $row;
            $i++;
        }
        mysql_free_result($result);
        return $returned;
    }

    //dues functions
    public function AddDues($memberid, $companyid, $date, $paid){
        $memberid = mysql_real_escape_string($memberid);
        $companyid = mysql_real_escape_string($companyid);
        $paid = mysql_real_escape_string($paid);
        $date = mysql_real_escape_string($date);
        $qry = "INSERT INTO `atud_ledger`.`atud_dues` (`member_fk`, `company_fk`, `date`, `paid`) VALUES ('".$memberid."', '".$companyid."', '".$date."', '".$paid."')";
        mysql_query($qry);
    }

    public function GrabDuesByID($id){
        $id = mysql_real_escape_string($id);
        $qry = "SELECT id, member_fk, company_fk, DATE_FORMAT(atud_dues.date, '%Y-%d-%m') as date, paid FROM atud_dues WHERE id = ".$id;
        $result = mysql_query($qry);
        $returned = mysql_fetch_row($result);
        mysql_free_result($result);
        return $returned;
    }

    public function GetDuesByDate($date, $company = NULL, $member = NULL){
        $date = mysql_real_escape_string($date);
        $qry = "SELECT * FROM atud_dues WHERE date = '".$date."'";
        if( !empty($company) ){
            $company = mysql_real_escape_string($company);
            $qry .= " AND company_fk = ".$company;
        }
        if( !empty($member) ){
            $member = mysql_real_escape_string($member);
            $qry .= " AND member_fk = ".$member;
        }


        if ( $result = mysql_query($qry) ){
            $returned = mysql_fetch_row($result);
            mysql_free_result($result);
            return $returned;
        }
        else{
            return false;
        }
    }

    public function GetDuesByMember($member, $date = NULL){
        $member = mysql_real_escape_string($member);
        $qry = "SELECT * FROM atud_dues WHERE date>=DATE_SUB(NOW(),INTERVAL 2 YEAR) AND member_fk=".$member;
        if( !empty($date) ){
            $qry .= " AND date=".$date;
        }
        $qry .= " ORDER BY date";
        //$qry .= " ORDER BY date desc";
        if( $result = mysql_query($qry) ){
            $i=0;
            while( $row = mysql_fetch_assoc($result) ){
                $returned[$i] = $row;
                $i++;
            }
            mysql_free_result($result);
            return $returned;
        }
        else{
            return false;
        }
    }

    public function GetDatesRecordedByCompany($company_id){
        $qry = "SELECT DISTINCT date FROM atud_dues WHERE company_fk=".$company_id;
        if( $result = mysql_query($qry) ){
            $i=0;
            while( $row = mysql_fetch_assoc($result) ){
                $returned[$i] = $row;
                $i++;
            }
            mysql_free_result($result);
            return $returned;
        }
        else{
            return false;
        }
    }

    public function UpdateDues($id, $paid, $date){
        $id = mysql_real_escape_string($id);
        $paid = mysql_real_escape_string($paid);
        $date = mysql_real_escape_string($date);
        $qry = "UPDATE `atud_ledger`.`atud_dues` SET `date`='".$date."', `paid`='".$paid."' WHERE `id`='".$id."';";
        mysql_query($qry);
    }

    public function RemoveDues($id){
        $id = mysql_real_escape_string($id);
        $qry = "DELETE FROM `atud_ledger`.`atud_dues` WHERE `id`='".$id."';";
        mysql_query($qry);
    }
}
