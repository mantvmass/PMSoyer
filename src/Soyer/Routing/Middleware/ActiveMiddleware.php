<?php

    /**
     * Copyright 2023 mantvmass
     * 
     * 
     */


    namespace Soyer\Routing\Middleware;

    /**
     * This is class of match router 
     */
    class ActiveMiddleware {


        /**
         * Store middlewares variable
         * 
         * @var array|null
         */
        private $middlewares = [];        


        /**
         * Constructor
         * 
         * @param array $middlewares
         */
        public function __construct($middlewares) {
            $this->middlewares = $middlewares;
        }


        /**
         * Execute middleware pipline
         * 
         * @param callable $handler
         * @param array $params
         */
        public function run($handler, $params) {

            $app = function() use($handler, $params) {
                $handler(...$params);
            };

            $next = $app;
            for ($i = count($this->middlewares) - 1; $i >= 0; $i--) {
                $currentMiddleware = $this->middlewares[$i];
                $next = function () use ($currentMiddleware, $next) {
                    $currentMiddleware::handle($next);  // execute the middleware and pass the $next function to the next.
                };
            }
            $next();
        }
    }
?>