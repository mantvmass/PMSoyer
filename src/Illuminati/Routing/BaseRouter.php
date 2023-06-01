<?php


    namespace Illuminati\Routing;


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
        private static function checkDuplicateRoute($path, $method) {
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
         * @param function $handler
         */
        public static function route($path, $methods, $handler) {

            foreach ($methods as $method) {
                // Call the method to check for duplicate paths
                self::checkDuplicateRoute($path, $method);
            }

            $route = [
                'path' => $path,
                'methods' => $methods,
                'handler' => $handler
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
         * @param Closure $handler
         */
        public static function errorHandler($statusCode, $handler) {
            self::$errorHandlers[$statusCode] = $handler;
        }


        /**
         * handleException function
         * 
         * @param int $statusCode
         * @param string $message
         */
        public static function handleException($statusCode, $message) {
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
        private static function convertToRegex($path) {
            // Convert route path to regular expression
            $regex = preg_replace('/\<(\w+)\>/', '(?P<$1>[^\/]+)', $path);
            $regex = '#^' . str_replace('/', '\/', $regex) . '$#';
            return $regex;
        }


        /**
         * getParams function | get params from router: /hi/<name>
         * 
         * @param array $params_from_route
         * @param Closure|string $function
         */
        private static function getParams($params_from_route, $function) {
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
         * @param array $method
         */
        public static function listen($path, $method) { // recieve request
            foreach (self::$routes as $route) {
                // Check if the route path and method match the request
                if (preg_match($route['regex'], $path, $matches) && in_array($method, $route['methods'])) {
                    
                    // Removes an array element whose key is a number.
                    $matches = array_filter($matches, function($key) {
                        return !is_numeric($key);
                    }, ARRAY_FILTER_USE_KEY);

                    // Get handler
                    $handler = $route['handler'];

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