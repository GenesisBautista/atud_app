<?php

class Session{

    public static function init(){
        session_start();
    }

    public static function kill(){
        unset($_SESSION);
        session_destroy();
    }

    public static function remove($key){
        unset($_SESSION[$key]);
    }

    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function get($key){
        return $_SESSION[$key];
    }

    public static function newarray($key){
        $_SESSION[$key] = array();
    }

    public static function add($key, $value){
        array_push($_SESSION[$key], $value);
    }
}