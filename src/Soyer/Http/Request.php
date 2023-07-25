<?php

    /**
     * Copyright 2023 mantvmass
     * 
     * 
     */


    namespace Soyer\Http;


    /**
     * This is request class
     */
    class Request {

        /**
         * This request method
         * 
         * @var string
         */
        public static $method;


        /**
         * This request path
         * 
         * @var string
         */
        public static $path;


        /**
         * This request data from $_GET and $_POST
         * 
         * @var array
         */
        public static $request;


        /**
         * This request fullpath
         * 
         * @var string
         */
        public static $full_path;


        /**
         * This request data form
         * 
         * @var array
         */
        public static $form;


        /**
         * This request data
         * 
         * @var array
         */
        public static $args;


        /**
         * This request data file
         * 
         * @var array
         */
        public static $files;


        /**
         * This is func update request data 
         */
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