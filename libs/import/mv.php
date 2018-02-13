<?php

class MV implements IImportPartser{
    function __construct(){
        $this->columns = array(
            'name'=>'3',
            'employee_id'=>'5',
            'date'=>'0',
            'dues'=>'11'
        );
    }

    public function notebuilder($array){
        return 'Name changed from '.$array['oldinfo']['fname'].' '.$array['oldinfo']['lname'].
            ' to '.$array['newinfo']['fname'].' '.$array['newinfo']['lname'];
    }

    public function cleandata($workbook){
        $columns = $this->columns;
        $cleaned = array();
        $date_info = array();
        $duesdates = array();
        foreach ($workbook as $sheetdata) {
            foreach( $sheetdata as $row=>$data ){
                if( $date = DateTime::createFromFormat('m/d/Y', $data[$columns['date']]) ){
                    array_push( $date_info, array('row'=>$row, 'date'=>$date->format('Y-m-d')) );
                    array_push( $duesdates, $date->format('Y-m-d') );
                }
            }
            Session::set('delinquentdate', $duesdates);
            foreach( $date_info as $period=>$info ){
                for($i=$info['row']+1; $i<count($sheetdata); $i++){
                    if( $sheetdata[$i][$columns['name']] == '' ){
                        if( $sheetdata[$i+1][$columns['name']] == ''  ){
                            if( $sheetdata[$i+2][$columns['name']] == '' ){
                                $i=count($sheetdata);
                            }else{
                                $i+=2;
                            }
                        }else{
                            $i++;
                        }
                    }

                    if( $sheetdata[$i][$columns['name']] != '' ){
                        $new_member = true;
                        foreach( $cleaned as $current=>$in_mem ){
                            if( $in_mem['employee_id'] == $sheetdata[$i][$columns['employee_id']]  ){
                                $cleaned[$current]['dues'][$period]['date'] = $info['date'];
                                $actualdues = ltrim($sheetdata[$i][$columns['dues']], '$');
                                if( !$cleaned[$current]['dues'][$period]['dues'] ){
                                    $cleaned[$current]['dues'][$period]['dues'] = $actualdues;
                                }else{
                                    $cleaned[$current]['dues'][$period]['dues'] += $actualdues;
                                }

                                $new_member = false;
                            }
                        }
                        if( $new_member ){
                            $name = explode( ', ', $sheetdata[$i][$columns['name']] );
                            array_push(
                                $cleaned,
                                array(
                                    'fname'=>trim($name[1]),
                                    'lname'=>trim($name[0]),
                                    'employee_id'=>$sheetdata[$i][$columns['employee_id']],
                                    'title'=>'Driver',
                                    'note'=>'',
                                    'dues'=>array(
                                        $period=>array(
                                            'date'=>$info['date'],
                                            'dues'=>ltrim($sheetdata[$i][$columns['dues']], '$')
                                        )
                                    )
                                )
                            );
                        }
                    }

                }
            }
        }
        return $cleaned;
    }
}
