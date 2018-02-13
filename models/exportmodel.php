<?php

class ExportModel extends Model{
    function __construct(){
        parent::__construct();

    }

    public function graballcompanies(){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabAllCompanies();
        $this->db->CloseConnection($link);
        return $return;
    }

    public function grabmembers($activeonly = 1, $company = NULL, $name = NULL){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabMembers($activeonly, $company, $name);
        $this->db->CloseConnection($link);
        return $return;
    }

    public function grabcompanyinfo($id){
        $link = $this->db->OpenConnection();
        $return = $this->db->GrabCompanyInfo($id);
        $this->db->CloseConnection($link);
        return $return;
    }

    public function generatememberreport($id){
        $link = $this->db->OpenConnection();
        $memberdues = $this->db->GetDuesByMember($id);
        $memberinfo = $this->db->GrabMemberInfo($id);
        $companyinfo = $this->db->GrabCompanyInfo($memberinfo[1]);
        $this->db->CloseConnection($link);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle($memberinfo[2]." ".$memberinfo[3]." Report")
            ->setSubject($memberinfo[2]." ".$memberinfo[3]." Report")
            ->setCreator("ATU Dues");

        $objPHPExcel->setActiveSheetIndex(0)->setTitle($memberinfo[2]." ".$memberinfo[3]);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Employee ID:')
            ->setCellValue('A2', 'Name:')
            ->setCellValue('A3', 'Company:')
            ->setCellValue('C1', $memberinfo[0])
            ->setCellValue('C2', $memberinfo[2]." ".$memberinfo[3])
            ->setCellValue('C3', $companyinfo[1]);

        $total=0;

        foreach($memberdues as $n=>$dues){
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($n, 5, $dues['date']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($n, 6, '$'.$dues['paid']);
            $total += $dues['paid'];
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Total: ');
        $objPHPExcel->getActiveSheet()->setCellValue('C8', '$'.$total);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="user_report.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function generatecompanyreports($id){
        $link = $this->db->OpenConnection();
        $members = $this->db->GetMembersByCompany($id);
        $qry = "SELECT CONCAT_WS(' ', MONTHNAME(date), YEAR(date)) as date
                    FROM atud_dues
                    WHERE company_fk=".$id."
                    GROUP BY YEAR(date), MONTHNAME(date)
                    ORDER BY atud_dues.date";
        $dates = $this->db->Query($qry);
        //$dates = $this->db->GetDatesRecordedByCompany($id);
        $this->db->CloseConnection($link);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle($members[0]['company_name']." Report")
            ->setSubject($members[0]['company_name']." Report")
            ->setCreator("ATU Dues");
        $objPHPExcel->setActiveSheetIndex(0)->setTitle($members[0]['company_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Employee ID')
            ->setCellValue('B1', 'First Name')
            ->setCellValue('C1', 'Last Name');

        foreach( $dates as $i=>$date){
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i+3, 1, $date['date']);
        }

        foreach( $members as $n=>$member){
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $n+2, $member['employee_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $n+2, $member['member_fname']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $n+2, $member['member_lname']);
            $link = $this->db->OpenConnection();
            $duesqry = "SELECT id, member_fk, company_fk, SUM(paid) as dues, CONCAT_WS(' ', MONTHNAME(date), YEAR(date)) as date
                        FROM atud_dues
                        WHERE member_fk=".$member['db_mem_id']."
                        GROUP BY member_fk, YEAR(date), MONTHNAME(date)
                        ORDER BY atud_dues.date";
            $dues = $this->db->Query($duesqry);
            //$dues = $this->db->GetDuesByMember($member['db_mem_id']);
            $this->db->CloseConnection($link);


            if( $dues ){
                $x = 0;
                for( $i=0; $i<count($dues); $i++ ){
                    if( $dues[$i]['date'] == $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($x+3, 1)->getValue() ){
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($x+3, $n+2, $dues[$i]['dues']);
                    }else{
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($x+3, $n+2, '0.00');
                        $i--;
                    }
                    $x++;
                }
            }
            else{
                foreach( $dates as $i=>$date){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i+3, $n+2, '0.00');
                }
            }
        }
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$members[0]['company_name'].'report.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function fullreport(){

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("Full Report")
            ->setSubject("Full Report")
            ->setCreator("ATU Dues");

        $link = $this->db->OpenConnection();
        $companies = $this->db->GrabAllCompanies();
        $this->db->CloseConnection($link);

        foreach( $companies as $c=>$company ){
            $objPHPExcel->createSheet();
            $objPHPExcel->setActiveSheetIndex($c)->setTitle($company['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Employee ID')
                ->setCellValue('B1', 'First Name')
                ->setCellValue('C1', 'Last Name');

            $link = $this->db->OpenConnection();
            $members = $this->db->GetMembersByCompany($company['id']);
            $qry = "SELECT CONCAT_WS(' ', MONTHNAME(date), YEAR(date)) as date
                    FROM atud_dues
                    WHERE company_fk=".$company['id']."
                    GROUP BY YEAR(date), MONTHNAME(date)
                    ORDER BY atud_dues.date";
            $dates = $this->db->Query($qry);
            $this->db->CloseConnection($link);

            if( $dates ){
                foreach( $dates as $i=>$date){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i+3, 1, $date['date']);
                }
            }

            if( $members ){
                foreach( $members as $n=>$member){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $n+2, $member['employee_id']);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $n+2, $member['member_fname']);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $n+2, $member['member_lname']);

                    $link = $this->db->OpenConnection();
                    $duesqry = "SELECT id, member_fk, company_fk, SUM(paid) as dues, CONCAT_WS(' ', MONTHNAME(date), YEAR(date)) as date
                        FROM atud_dues
                        WHERE member_fk=".$member['db_mem_id']."
                        GROUP BY member_fk, YEAR(date), MONTHNAME(date)
                        ORDER BY atud_dues.date";
                    $dues = $this->db->Query($duesqry);
                    $this->db->CloseConnection($link);

                    if( $dues ){
                        $x = 0;
                        for( $i=0; $i<count($dates); $i++ ){
                            //echo $c.'-'.$n.'-'.$i.'-'.$x.' '.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($x+3, 1)->getValue().'<br>';
                            if( $dues[$i]['date'] == $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($x+3, 1)->getValue() ){
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($x+3, $n+2, $dues[$i]['dues']);
                            }else{
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($x+3, $n+2, '0.00');
                                $i--;
                            }
                            $x++;
                            $i = ($x == count($dates)+3 ? count($dues) : $i);
                        }
                    }
                    else{
                        foreach( $dates as $i=>$date){
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i+3, $n+2, '0.00');
                        }
                    }
                }
            }
        }
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$members[0]['company_name'].'report.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}