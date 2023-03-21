<?php

    use Illuminati\View\Template;

    // if (!function_exists('render_template')) {
    //     /**
    //      * Get an instance of the redirector.
    //      *
    //      * @param  string|null  $to
    //      * @param  int  $status
    //      */

    //     function render_template($to = null, $status = 302){
    //         return header("Location: $to", true, $status);
    //     }
    // }

    if (!function_exists('redirect')) {
        /**
         * Get an instance of the redirector.
         *
         * @param  string|null  $to
         * @param  int  $status
         */

        function redirect($to = null, $status = 302){
            return header("Location: $to", true, $status);
        }
    }