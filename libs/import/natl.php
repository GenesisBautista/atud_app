<?php

class NATL implements IImportPartser{
    function __construct(){
        $this->startingrow = 17;
        $this->columns = array(
            'name'=>'0',
            'employee_id'=> '1',
            'date1'=> array('3','0'),
            'date2'=> array('4','0'),
            'dues' => '2'
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
        $sheetdata = $workbook[0];
        $date1 = substr($sheetdata[$columns['date1'][0]][$columns['date1'][1]], -11);
        $date2 = substr($sheetdata[$columns['date2'][0]][$columns['date2'][1]], -11);
        $date1 = DateTime::createFromFormat( 'd-M-Y', $date1 );
        $date2 = DateTime::createFromFormat( 'd-M-Y', $date2 );
        $date1 = $date1->format('Y-m-d');
        $date2 = $date2->format('Y-m-d');
        $duesdates = array(
            'date1'=>$date1,
            'date2'=>$date2
        );
        Session::set('delinquentdate', $duesdates);
        for( $i=$startingrow; $i<count($sheetdata); $i=$i+2 ){
            if( $sheetdata[$i][$columns['name']] != '' ){
                $name = $name = explode( ',', $sheetdata[$i][$columns['name']] );
                $actualdues1 = ltrim($sheetdata[$i][$columns['dues']], '$');
                $actualdues2 = ltrim($sheetdata[$i+1][$columns['dues']], '$');
                array_push(
                    $cleaned,
                    array(
                        'fname'=>trim($name[1]),
                        'lname'=>trim($name[0]),
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
        }
        return $cleaned;
    }
}
