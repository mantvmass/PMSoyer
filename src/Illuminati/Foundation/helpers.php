<?php

    use Illuminati\Auduct as app;
    use Illuminati\View\Template;
    use Illuminati\View\TemplateFileSystemLoader;

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

    if (!function_exists('redirect')) {
        /**
         * Get an instance of the redirector.
         *
         * @param  string|null  $to
         * @param  int  $status
         */

        function redirect(string $to = null, int $status = 302){
            return header("Location: $to", true, $status);
        }
    }

    if (!function_exists('abort')) {
        /**
         * The abort function.
         * @param  int  $code
         * @param  string|null  $message
         */
        function abort(int $code, string $message = '') {
            app::handleException($code, $message);
            return;
        }
    }