<?php

class FTE implements IImportPartser{
    function __construct(){
        $this->startingrow = 1;
        $this->columns = array(
            'name'=>'3',
            'employee_id'=> '6',
            'date'=>'7',
            'dues'=>'9',
            'title'=>'4'
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
        for( $i=$startingrow; $i<count($sheetdata); $i++ ){
            if( $sheetdata[$i][$columns['name']] == '' && $sheetdata[$i][$columns['employee_id']] == '' ){
                $i = count($sheetdata);
            }else{
                $name = explode( ',', $sheetdata[$i][$columns['name']] );
                $dues = explode( ' ', $sheetdata[$i][$columns['dues']] );
                $date = DateTime::createFromFormat( 'm/d/Y', $sheetdata[$i][$columns['date']] );
                array_push(
                    $cleaned,
                    array(
                        'fname'=>$name[1],
                        'lname'=>$name[0],
                        'employee_id'=>$sheetdata[$i][$columns['employee_id']],
                        'title'=>$sheetdata[$i][$columns['title']],
                        'note'=>'',
                        'dues'=>array(
                            array(
                                'dues'=>$dues[1],
                                'date'=>$date->format('Y-m-d')
                            )
                        )
                    )
                );
            }
        }
        Session::newarray('delinquentdate');
        Session::add('delinquentdate', $date->format('Y-m-d'));
        return $cleaned;
    }
}
