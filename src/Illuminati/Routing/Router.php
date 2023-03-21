<?php


    namespace Illuminati\Routing;

    use Illuminati\Http\Request;
    use Exception;

    class Router {

        /**
         * The config application
         * 
         * @var array|null
         */
        public static $config = [];

        /**
         * The parameters for get methods
         * 
         * @var array|null
         */
        public static $params = [];

        /**
         * The forms for post methods
         * 
         * @var array|null
         */
        public static $forms = [];

        /**
         * The method requests
         * 
         * @var string|null
         */
        public static $request_method = null;

        /**
         * The path requests
         * 
         * @var string|null
         */
        public static $request_path = null;


        /**
         * The error route | sub switch routing to 404 code
         * 
         * @var boolean
         */
        private static $error_route = true;


        /**
         * The function process url 
         * 
         * @param string $request_url
         */
        private static function processUrl($request_url){

            for ($i=0; $i < strlen($request_url); $i++) { // if have '?' in requests url set params
                if ($request_url[$i] == '?') {
                    $new_request_url = explode("?", $request_url);
                    self::paramsSet(null, null, $new_request_url[1], "?");
                    $request_url = $new_request_url[0];
                    break;
                }
            }


            $split_req = explode("/", $request_url);
            if ($split_req[0] == '' && $split_req[1] == '' || $request_url == '') { 
                return ["/", 0]; 
            }


            return [$request_url, $split_req];

        }   

        private static function processRoute($route){

            $split_route = explode("/", $route);

            if ($split_route[0] == '' && $split_route[1] == '') { 
                return ["/", 0];
            }

            $position = array();
            $position_key = array();
            $newRoute = '';

            for ($i=1; $i < count($split_route); $i++) { 

                if ($split_route[$i][0] == ":") {

                    array_push($position, $i);
                    $sumkey = '';

                    for ($o=0; $o < strlen($split_route[$i]); $o++) { 

                        if ($split_route[$i][$o] != ":"){
                            $sumkey = $sumkey.$split_route[$i][$o];
                        }

                    }

                    array_push($position_key, $sumkey);

                } else {

                    $newRoute = $newRoute.'/'.$split_route[$i];

                }
            }

            if (count($position) != 0) {
                return [$newRoute, $position, $position_key];
            }

            return [$route, 0];
        }

        private static function paramsSet($route, $request_url, $request_params=null, $mode=":"){ // set param for GET Methods

            switch ($mode) {

                case ':':

                    $key_param = self::processRoute($route);
                    $value_param = self::processUrl($request_url);
                    if ($key_param[1] != 0 && $key_param[1] != 0){
                        for ($i=0; $i < count($key_param[1]); $i++) { 
        
                            if(array_key_exists($key_param[2][$i], self::$params)){
                                throw new Exception("This key '" . $key_param[2][$i] . "' already exists. cannot be reassigned");
                            }
        
                            self::$params += [ $key_param[2][$i] => $value_param[1][$key_param[1][$i]] ]; // push to params
                            
                        }
                    }
                    break;
                
                case '?':
                    
                    $spit_params = explode("&", $request_params);
                    for ($i=0; $i < count($spit_params); $i++) { 
                        $KeyAndValue = ['',''];
                        $counter = 0;
                        for ($o=0; $o < strlen($spit_params[$i]); $o++){ // add key
                            if($spit_params[$i][$o] == "="){ // first find '='
                                break;
                            }
                            $KeyAndValue[0] .= $spit_params[$i][$o];
                            $counter++;
                        }
                        $lens = strlen($spit_params[$i])-$counter;
                        if ($lens <= 1 || $lens == 0) { // check value empty
                            self::$params += [  $KeyAndValue[0] => '' ]; // add params | value empty
                            break;
                        }
                        $KeyAndValue[1] .= substr($spit_params[$i], $counter+1); // get value
                        self::$params += [ $KeyAndValue[0] => $KeyAndValue[1] ]; // add params
                    }
                    break;

            }
           
        }
        

        private static function matcRequest($route, $request_url){
            if (count(explode("/", $route)) != count(explode("/", $request_url))) { return false; }
            
            self::paramsSet($route, $request_url); // set params for methods get
            // access router path
            $key_param = self::processRoute($route);
            $value_param = self::processUrl($request_url);
            self::$request_path = $key_param[0]; // get path request
            if ($key_param[0] == $value_param[0]) { return true; }

            $route_sub = explode("/", $key_param[0]);
            $url_sub = explode("/", $value_param[0]);
            $status = true;
            for ($i=0; $i < count($route_sub); $i++) { 
                if ($route_sub[$i] != $url_sub[$i]) { $status = false; }
            }
            return $status;
        }

        public static function route($route, $methods=["GET"], $function=null){

            $request_url = Request::url(); // Get requests path and params

            if (self::matcRequest($route, $request_url)) {

                //sub switch
                self::$error_route = false;

                /**
                 * Check method requests
                 */
                $status_method = false;
                for ($i=0; $i < count($methods); $i++) { 
                    if ($methods[$i] == Request::method()){
                        $status_method = true;
                        self::$request_method = Request::method();
                        break;
                    }
                }
                if (!$status_method) {
                    http_response_code(405); // send http error code
                    throw new Exception("405 Method Not Allowed");
                    // exit();
                }


                self::$forms = Request::forms(); // set post value


                // http_response_code(200); // send http error code
                return $function(); // call function
            }
            // die(); // prevent checking all other routes
        }

        public static function errorhandler($code, $function){
            if (self::$error_route) {
                $function(); // call function
                http_response_code($code); // send http error code
            }
        }

    }

?>