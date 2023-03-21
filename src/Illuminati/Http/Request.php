<?php


namespace Illuminati\Http;


class Request {

    public static function method(){
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function url(){
        return $_SERVER['REQUEST_URI'];
    }

    public static function forms(){
        return $_POST;
    }

}