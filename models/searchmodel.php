<?php

class SearchModel extends Model{
    function __construct($name){
        switch ($name) {
            case "members": $this->SearchParser = Model::LoadModel("search/membersearch"); break;
        }
    }

    public function GetTotalResults($arr){
        $a = $this->SearchParser;
        return call_user_func_array(array($a, 'GetTotalResults'), $arr);
    }

    public function GetSearchResults($arr){
        $a = $this->SearchParser;
        return call_user_func_array(array($a, 'GetSearchResults'), $arr);
    }

    public function GenerateURLString($searcharr){
        $return = array(
            $searcharr['page'],
            $searcharr['sort'],
            $searcharr['sorttype'],
            !empty($searcharr['active'])?$searcharr['active']:0,
            $searcharr['company'],
            !empty($searcharr['name'])?$searcharr['name']:'empty');
        return implode(":", $return);
    }

    public function GeneratePageArray($currentpage, $totalpages){
        $pagesdisplayed = 5;
        if( $totalpages < $pagesdisplayed ){
            $floor = 1;
            $ceiling = $totalpages;
        }else if( $currentpage >= 1 && $currentpage <= 2 ){
            $floor = 1;
            $ceiling = $pagesdisplayed;
        }else if( ($currentpage+2) >= $totalpages ){
            $floor = $totalpages - ($pagesdisplayed-1);
            $ceiling = $totalpages;
        }else{
            $floor = $currentpage - 2;
            $ceiling = $currentpage + 2;
        }
        for( $i = $floor; $i <= $ceiling; $i++){
            $return[$i] = ( $currentpage == $i ? 'current' : 'page' );
        }
        return $return;
    }
}
