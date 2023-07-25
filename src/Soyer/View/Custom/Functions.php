<?php

    /**
     * Copyright 2023 mantvmass
     * 
     * 
     */
    

    namespace Soyer\View\Custom;


    /**
     * This is class store function for twig engine
     */
    class Functions {


        /**
         * generateAssetUrl function
         * 
         * @param string $static
         * @param string $assetPath
         */
        public static function generateAssetUrl(string $static, string $assetPath){
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $domain = $protocol . $_SERVER['HTTP_HOST'];
            return rtrim($domain, '/') . '/' . $static . '/' . ltrim($assetPath, '/');
        }

    }

?>