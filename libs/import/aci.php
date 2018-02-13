<?php

class ACI implements IImportPartser{
    function __construct(){
        $this->startingrow = array(6, 2);
        $this->columns = array(
            'fname'=>'2',
            'lname'=>'1',
            'employee_id'=> '0',
            'date_row'=> '4',
            'note' => '9',
            'dues' => array(
                'week1' => '4',
                'week2' => '5',
                'week3' => '6',
                'week4' => '7',
                'week5' => '8'
            )
        );
    }

    public function notebuilder($array){
        return 'Name changed from '.$array['oldinfo']['fname'].' '.$array['oldinfo']['lname'].
            ' to '.$array['newinfo']['fname'].' '.$array['newinfo']['lname'].'. '.$array['notes'];
    }

    public function cleandata($workbook){
        $columns = $this->columns;
        $startingrow = $this->startingrow;
        $cleaned = array();
        $duesdates = array();
        foreach ($workbook as $x=>$sheetdata) {

            if( $x == 0 ){
                foreach( $columns['dues'] as $week=>$column ){
                    $date = DateTime::createFromFormat( 'm/d/Y', $sheetdata[$columns['date_row']][$column] );
                    if( $date != false ){
                        $duesdates[$week] = $date->format('Y-m-d');
                    }else{
                        break;
                    }
                }
                Session::set('delinquentdate', $duesdates);
            }
            for( $i=$startingrow[$x]; $i<=count($sheetdata); $i++ ){

                if( $sheetdata[$i][$columns['lname']] == '' && $sheetdata[$i][$columns['employee_id']] == '' ){
                    $i = count($sheetdata)+1;
                }else{
                    $dues = array();
                    foreach( $duesdates as $week=>$date ){
                        $actualdues = ltrim($sheetdata[$i][$columns['dues'][$week]], '$');
                        $dues[$week]['date'] = $date;
                        $dues[$week]['dues'] = $actualdues;
                    }
                    array_push(
                        $cleaned,
                        array(
                            'fname'=>$sheetdata[$i][$columns['fname']],
                            'lname'=>$sheetdata[$i][$columns['lname']],
                            'title'=>'Driver',
                            'note'=>$sheetdata[$i][$columns['note']],
                            'employee_id'=>$sheetdata[$i][$columns['employee_id']],
                            'dues'=>$dues
                        )
                    );
                }
            }
        }
        return $cleaned;
    }
}
