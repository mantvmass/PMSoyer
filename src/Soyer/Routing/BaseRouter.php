<?php


    namespace Soyer\Routing;


    use ReflectionFunction;
    use Exception;


    /**
     * This is class main router
     * 
     */
    class BaseRouter {


        /**
         * This route from application
         * 
         * @var array|null
         */
        private static $routes = [];


        /**
         * This errorHandlers from application
         * 
         * @var array|null
         */
        private static $errorHandlers = [];


        /**
         * Method for checking for duplicate paths
         * 
         * @param string $path
         * @param string $method
         */
        private static function checkDuplicateRoute(string $path, string $method) {
            foreach (self::$routes as $route) {
                if ($route["path"] == $path && in_array($method, $route["methods"])) {
                    throw new Exception("Duplicate route: $path [$method]");
                }
            }
        }


        /**
         * Add route function
         * 
         * @param string $path
         * @param array $method
         * @param callable $handler
         */
        public static function route(string $path, array $methods, callable $handler, array $middlewares = []) {

            foreach ($methods as $method) {
                // Call the method to check for duplicate paths
                self::checkDuplicateRoute($path, $method);
            }

            $route = [
                'path' => $path,
                'methods' => $methods,
                'handler' => $handler,
                'middlewares' => $middlewares
            ];

            // Convert route path to regular expression
            $route['regex'] = self::convertToRegex($path);

            // Add route
            self::$routes[] = $route;
        }


        /**
         * Add errorHandler function
         * 
         * @param int $statusCode
         * @param callable $handler
         */
        public static function errorHandler(int $statusCode, callable $handler) {
            self::$errorHandlers[$statusCode] = $handler;
        }


        /**
         * handleException function
         * 
         * @param int $statusCode
         * @param string $message
         */
        public static function handleException(int $statusCode, string $message) {
            if (isset(self::$errorHandlers[$statusCode])) {
                $handler = self::$errorHandlers[$statusCode];
                http_response_code($statusCode);
                $handler(new Exception($message));
            } else {
                http_response_code($statusCode);
                echo "Error $statusCode: $message";
            }
            return;
        }


        /**
         * convertToRegex function
         * 
         * @param string $path
         */
        private static function convertToRegex(string $path) {
            // Convert route path to regular expression
            $regex = preg_replace('/\<(\w+)\>/', '(?P<$1>[^\/]+)', $path);
            $regex = '#^' . str_replace('/', '\/', $regex) . '$#';
            return $regex;
        }


        /**
         * getParams function | get params from router: /hi/<name>
         * 
         * @param array $params_from_route
         * @param callable $function
         */
        private static function getParams(array $params_from_route, callable $function) {
            $reflection = new ReflectionFunction($function);
            $params = $reflection->getParameters();
            $resolvedParams = [];
    
            foreach ($params as $param) {
                $paramName = $param->getName();
                $resolvedParams[] = $params_from_route[$paramName] ?? null;
            }
    
            return $resolvedParams;
        }


        /**
         * listen function
         * 
         * @param string $path
         * @param string $method
         */
        public static function listen(string $path, string $method) { // recieve request
            foreach (self::$routes as $route) {
                // Check if the route path and method match the request
                if (preg_match($route['regex'], $path, $matches) && in_array($method, $route['methods'])) {
                    
                    // Removes an array element whose key is a number.
                    $matches = array_filter($matches, function($key) {
                        return !is_numeric($key);
                    }, ARRAY_FILTER_USE_KEY);

                    // Get handler
                    $handler = $route['handler'];
                    $middlewares = $route['middlewares'];

                    // call middlewares
                    foreach ($middlewares as $middleware) {
                        // if (is_callable($middleware[0])) { // function middleware
                        //     $middleware[0]();
                        // } else { // class middleware
                        //     $middlewareClass = $middleware[0];
                        //     $middlewareMethod = $middleware[1];
                        //     $middlewareClass::$middlewareMethod();
                        // }

                        // call class middleware only
                        $middlewareClass = $middleware;
                        $middlewareClass::handle();
                        
                    }

                    // Combine route params and additional params
                    $params = [];
                    $params = array_merge($matches, $params);
                    $params = self::getParams($params, $handler);

                    // Call the route handler function with the params
                    $handler(...$params);

                    return;
                }
            }
            self::handleException(404, 'Not Found');
        }

    }

?>