<?php

class Model{
    function __construct(){
        $this->db = new Database();
    }

    static function LoadModel($path, $param = NULL){
        $patharray = explode('/', $path);
        $name = array_pop($patharray);
        $file = 'models/'.$path.'model.php';
        $return = NULL;
        if( file_exists($file) ){
            require $file;

            $modelName = $name.'Model';
            $return = new $modelName($param);
        }
        return $return;
    }
}
