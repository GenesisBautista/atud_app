<?php

interface IImportPartser{
    public function cleandata($sheetdata);
    public function notebuilder($array);
}

require 'libs/import/aci.php';
require 'libs/import/fte.php';
require 'libs/import/ftw.php';
require 'libs/import/mv.php';
require 'libs/import/natl.php';
require 'libs/import/trans.php';
require 'libs/import/rcc.php';
require 'libs/import/default.php';

class ImportExtended{
    function __construct($company_id){
        $this->db = new Database();
        switch ($company_id) {
            case 1: $this->CompanyParser = new ACI(); break;
            case 2: $this->CompanyParser = new FTE(); break;
            case 3: $this->CompanyParser = new FTW(); break;
            case 4: $this->CompanyParser = new MV(); break;
            case 5: $this->CompanyParser = new NATL(); break;
            case 6: $this->CompanyParser = new TRANS(); break;
            case 7: $this->CompanyParser = new RCC(); break;
            default: $this->CompanyParser = new DefaultCompany(); break;
        }
    }

    public function CleanData($sheetdata){
        return $this->CompanyParser->cleandata($sheetdata);
    }

    public function getexcelobject($file){
        $workbook = array();
        $xlsobj = PHPExcel_IOFactory::load($file);
        for( $i = 0; $i < $xlsobj->getSheetCount(); $i++ ){
            if( $xlsobj->setActiveSheetIndex($i)->getHighestrow() > 1 ){
                $edgeofexistence = $xlsobj->getActiveSheet()->getHighestRowAndColumn();
                array_push( $workbook, $xlsobj->getActiveSheet()->rangeToArray('A1:Z'.$edgeofexistence['row']) );
            }
        }
        return $workbook;
    }

    public function loopthroughdata($sheetdata){
        $usedids = array();
        Session::newarray('flaggedmemberinfo');
        foreach( $sheetdata as $member ){
            $link = $this->db->OpenConnection();
            //check if user exists
            $memberinfo = $this->db->GrabMemberInfoByCompanyID($member['employee_id'], Session::get('company_id'));
            if( $memberinfo ){
                //check if name is the same
                if( $memberinfo[3] == $member['lname'] && $memberinfo[2] == $member['fname'] ){
                    //add dues to db
                    foreach( $member['dues'] as $dues ){
                        if( $duesinfo = $this->db->GetDuesByDate($dues['date'], $memberinfo[1], $memberinfo[0])){
                            //update record
                            $this->db->UpdateDues($duesinfo[0], $dues['dues'], $dues['date']);
                        }
                        else{
                            //create new record
                            $this->db->AddDues( $memberinfo[0], $memberinfo[1], $dues['date'], $dues['dues'] );
                        }
                    }
                    array_push($usedids, $memberinfo[0]);
                }else{
                    $member['possible_id'] = $memberinfo[0];
                    Session::add('flaggedmemberinfo', $member);
                }
            }else{
                Session::add('flaggedmemberinfo', $member);
            }
            $this->db->CloseConnection($link);
        }
        Session::set('usedids', $usedids);
    }

    public function runflags(){
        //make sure post data exists
        if( !empty($_POST['member']) ){
            $usedids = array();
            foreach( $_POST['member'] as $member ){
                $link = $this->db->OpenConnection();
                //check if member is new or had name change
                if( $member['flag'] == 'new' ){
                    //create new member
                    $this->db->CreateNewMembers(
                        Session::get('company_id'),
                        $member['fname'],
                        $member['lname'],
                        $member['title'],
                        $member['employee_id']
                    );
                    $id = mysql_insert_id();
                    //create dues record
                    foreach( $member['dues'] as $dues ){
                        $this->db->AddDues( $id, Session::get('company_id'), $dues['date'], $dues['dues'] );
                    }
                    array_push($usedids, $id);
                }else if( $member['flag'] == 'existing' ){
                    //update member's name
                    $oldinfo = $this->db->GrabMemberInfo($member['member_id']);
                    $this->db->UpdateMember(
                        $member['member_id'],
                        Session::get('company_id'),
                        $member['fname'],
                        $member['lname'],
                        $member['title'],
                        $member['employee_id'],
                        $this->CompanyParser->notebuilder(array(
                            'oldinfo' => array(
                                'fname' => $oldinfo[2],
                                'lname' => $oldinfo[3],
                            ),
                            'newinfo' => $member
                        ))
                    );
                    foreach( $member['dues'] as $dues ){
                        //check if dues record exists
                        if( $duesinfo = $this->db->GetDuesByDate($dues['date'], $oldinfo[1], $oldinfo[0])){
                            //update record
                            $this->db->UpdateDues($duesinfo[0], $dues['dues'], $dues['date']);
                        }
                        else{
                            //create new record
                            $this->db->AddDues( $oldinfo[0], $oldinfo[1], $dues['date'], $dues['dues'] );
                        }
                    }
                    array_push($usedids, $member['member_id']);
                }
                $this->db->CloseConnection($link);
            }
            if( empty($_SESSION['usedids']) ){
                Session::set('usedids', $usedids);
            }else{
                Session::set('usedids', array_merge(Session::get('usedids'), $usedids));
            }
        }
    }

    public function rundelinquents(){
        if( !empty($_POST['member']) ){
            foreach( $_POST['member'] as $member ){
                $link = $this->db->OpenConnection();
                if( $member['action'] == 'delinquent' || $member['action'] == 'official' ){
                    foreach( $member['date'] as $date ){
                        $this->db->AddDues($member['id'], $_POST['company_id'], $date, 0);
                    }
                }
                else if( $member['action'] == 'deactivate' ){
                    $this->db->RemoveMember($member['id']);
                }
                $this->db->CloseConnection($link);
            }
        }
    }
}
