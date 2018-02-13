<?php

class DefaultCompany implements IImportPartser{
    function __construct(){
        $this->startingrow = 4;
        $this->columns = array(
            'name'=>'2',
            'employee_id'=> '1',
            'dues'=>array(
                array(
                    'date'=>'4',
                    'dues'=>'5'
                ),
                array(
                    'date'=>'6',
                    'dues'=>'7'
                )
            )
        );
    }

    public function notebuilder($array){
        return $array['notes'];
    }

    public function cleandata($workbook){
        $columns = $this->columns;
        $startingrow = $this->startingrow;
        $cleaned = array();
        foreach($workbook as $x=>$sheetdata){
            if( $x == 2 ){ break; }
            for( $i=$startingrow; $i<count($sheetdata); $i++ ){
                if( $sheetdata[$i][$columns['name']] != '' ){
                    $actualdues1 = ltrim($sheetdata[$i][$columns['dues'][0]['dues']], '$');
                    $actualdues2 = ltrim($sheetdata[$i][$columns['dues'][1]['dues']], '$');
                    if( $turn_date = DateTime::createFromFormat( 'm/d/Y', $sheetdata[$i][$columns['dues'][0]['date']] ) )
                        $date1 = $turn_date->format('Y-m-d');
                    if( $turn_date = DateTime::createFromFormat( 'm/d/Y', $sheetdata[$i][$columns['dues'][1]['date']] ) )
                        $date2 = $turn_date->format('Y-m-d');
                    $name = explode( ',', $sheetdata[$i][$columns['name']] );
                    array_push(
                        $cleaned,
                        array(
                            'fname'=>$name[1],
                            'lname'=>$name[0],
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
