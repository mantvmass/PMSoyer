<?php

    namespace Soyer\Routing\Middleware;

    class ActiveMiddleware {

        private $middlewares = [];        

        public function __construct($middlewares) {
            $this->middlewares = $middlewares;
        }

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