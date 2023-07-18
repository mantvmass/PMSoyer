<?php


    namespace Soyer\Http;

    class Request {


        public static $method;
        public static $path;
        public static $request;
        public static $full_path;
        public static $form;
        public static $args;
        public static $files;


        public static function handleRequest(){
            self::$method = $_SERVER['REQUEST_METHOD'];
            self::$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            self::$request = $_REQUEST;
            self::$full_path = $_SERVER['REQUEST_URI'];
            self::$form = $_POST;
            self::$args = $_GET;
            self::$files = $_FILES;
        }

    }