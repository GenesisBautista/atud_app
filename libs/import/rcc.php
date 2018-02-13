<?php

class RCC implements IImportPartser{
    function __construct(){
        $this->startingrow = 5;
        $this->columns = array(
            'fname'=>'3',
            'lname'=>'2',
            'employee_id'=> '1',
            'dues'=>array(
                array(
                    'date'=>'5',
                    'dues'=>'6'
                ),
                array(
                    'date'=>'7',
                    'dues'=>'8'
                )
            )
        );
    }

    public function notebuilder($array){
        return 'Name changed from '.$array['oldinfo']['fname'].' '.$array['oldinfo']['lname'].
            ' to '.$array['newinfo']['fname'].' '.$array['newinfo']['lname'];
    }

    public function cleandata($workbook){
        $columns = $this->columns;
        $startingrow = $this->startingrow;
        $cleaned = array();
        foreach($workbook as $x=>$sheetdata){
            if( $x == 2 ){ break; }
            for( $i=$startingrow; $i<count($sheetdata); $i++ ){
                if( $sheetdata[$i][$columns['fname']] != '' ){
                    $actualdues1 = ltrim($sheetdata[$i][$columns['dues'][0]['dues']], '$');
                    $actualdues2 = ltrim($sheetdata[$i][$columns['dues'][1]['dues']], '$');
                    if( $turn_date = DateTime::createFromFormat( 'm/d/Y', $sheetdata[$i][$columns['dues'][0]['date']] ) )
                        $date1 = $turn_date->format('Y-m-d');
                    if( $turn_date = DateTime::createFromFormat( 'm/d/Y', $sheetdata[$i][$columns['dues'][1]['date']] ) )
                        $date2 = $turn_date->format('Y-m-d');
                    array_push(
                        $cleaned,
                        array(
                            'fname'=>$sheetdata[$i][$columns['fname']],
                            'lname'=>$sheetdata[$i][$columns['lname']],
                            'employee_id'=>$sheetdata[$i][$columns['employee_id']],
                            'title'=>'Driver',
                            'note'=>'',
                            'dues'=>array(
                                array(
                                    'date'=>$date1,
                                    'dues'=>$actualdues1
                                ),
                                array(
                                    'date'=>$date2,
                                    'dues'=>$actualdues2
                                )
                            )
                        )
                    );
                }else{
                    $i = count($sheetdata);
                }
                $duesdates = array(
                    'date1'=>$date1,
                    'date2'=>$date2
                );
            }
        }
        Session::set('delinquentdate', $duesdates);
        return $cleaned;
    }
}
