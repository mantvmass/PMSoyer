<?php


    namespace Illuminati\Http;

    class Request {


        public static $method;
        public static $path;
        public static $full_path;
        public static $form; // html form
        public static $args; // url.com/?key = value
        public static $files; // url.com/?key = value


        public static function handleRequest(){
            self::$method = $_SERVER['REQUEST_METHOD'];
            self::$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            self::$full_path = $_SERVER['REQUEST_URI'];
            self::$form = $_POST;
            self::$args = $_GET;
            self::$files = $_FILES;
        }

    }