<?php

    use Soyer\Auduct as app;
    use Soyer\View\Template;
    use Soyer\View\TemplateFileSystemLoader;

    if (!function_exists('render_template')) {
        /**
         * This function render_template
         *
         * @param  string  $name
         * @param  array|null  $context
         */

        function render_template(string $name, array $context = []){
            $templates_path = isset(app::$config["TEMPLATES_PATH"]) ? app::$config["TEMPLATES_PATH"] : "templates/";
            $loader = new TemplateFileSystemLoader(__DIR__ . "/../../../../../../" . $templates_path);
            $page = new Template($loader);
            echo $page -> render($name, $context);
            return;
        }
    }

    if (!function_exists('basic_render_template')) {
        /**
         * This function basic_render_template
         *
         * @param  string  $name
         */

        function basic_render_template(string $name){
            $templates_path = isset(app::$config["TEMPLATES_PATH"]) ? app::$config["TEMPLATES_PATH"] : "templates/";
            return require_once(__DIR__ . "/../../../../../../" . $templates_path . $name);
        }
    }

    if (!function_exists('jsonify')) {
        /**
         * Get an instance of the redirector.
         *
         * @param  array  $data
         * @param  int  $statusCode
         */

        function jsonify(array $data, int $statusCode = 200){
            http_response_code($statusCode);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
    }

    if (!function_exists('redirect')) {
        /**
         * Get an instance of the redirector.
         *
         * @param  string|null  $to
         * @param  int  $statusCode
         */

        function redirect(string $to = null, int $statusCode = 302){
            return header("Location: $to", true, $statusCode);
        }
    }

    if (!function_exists('abort')) {
        /**
         * The abort function.
         * @param  int  $statusCode
         * @param  string|null  $message
         */

        function abort(int $statusCode, string $message = '') {
            app::handleException($statusCode, $message);
            die();
        }
    }

    if (!function_exists('abortWithJson')) {
        /**
         * The abort function.
         * @param  int $statusCode
         * @param  array $data
         */

        function abortWithJson(int $statusCode, array $data) {
            http_response_code($statusCode);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
            die();
        }
    }