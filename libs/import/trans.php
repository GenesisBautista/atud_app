<?php

class TRANS implements IImportPartser{
    function __construct(){
        $this->startingrow = 1;
        $this->columns = array(
            'name'=>'3',
            'employee_id'=> '2',
            'note'=>'13',
            'dues'=>array(
                array(
                    'date'=>'4',
                    'dues'=>'6'
                ),
                array(
                    'date'=>'7',
                    'dues'=>'8'
                ),
                array(
                    'date'=>'9',
                    'dues'=>'10'
                ),
                array(
                    'date'=>'11',
                    'dues'=>'12'
                )
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
        foreach($workbook as $sheetdata){
            if( $sheetdata[0][0] != 'Pay Group' ){ continue; }
            for( $i=$startingrow; $i<count($sheetdata); $i++ ){
                if( $sheetdata[$i][$columns['name']] != '' ){
                    $name = $name = explode( ',', $sheetdata[$i][$columns['name']] );
                    $dues_array= array();
                    foreach( $columns['dues'] as $dues ){
                        $actualdues = str_replace(array( '(', ')', '$' ), '', $sheetdata[$i][$dues['dues']]);
                        $actualdues = trim($actualdues, ' ');
                        if( $turn_date = DateTime::createFromFormat('m/d/y', $sheetdata[$i][$dues['date']]) )
                            $actualdate = $turn_date->format('Y-m-d');
                        else if( $turn_date = DateTime::createFromFormat('m/d/Y', $sheetdata[$i][$dues['date']]) )
                            $actualdate = $turn_date->format('Y-m-d');
                        array_push(
                            $dues_array,
                            array(
                                'date'=>$actualdate,
                                'dues'=>$actualdues
                            )
                        );
                    }
                    array_push(
                        $cleaned,
                        array(
                            'fname'=>trim($name[1]),
                            'lname'=>trim($name[0]),
                            'employee_id'=>$sheetdata[$i][$columns['employee_id']],
                            'title'=>'Driver',
                            'note'=>$sheetdata[$i][$columns['note']],
                            'dues'=>$dues_array
                        )
                    );
                }else{
                    $i = count($sheetdata);
                }
                $duesdates = array(
                    'date1'=>$dues_array[0]['date'],
                    'date2'=>$dues_array[1]['date'],
                    'date3'=>$dues_array[2]['date'],
                    'date4'=>$dues_array[3]['date']
                );
            }
        }
        Session::set('delinquentdate', $duesdates);
        return $cleaned;
    }
}
