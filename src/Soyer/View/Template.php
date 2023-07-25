<?php

    /**
     * Copyright 2023 mantvmass
     * 
     * 
     */


    namespace Soyer\View;

    use Soyer\View\TemplateFileSystemLoader;
    use Twig\Environment;
    use Twig\TwigFunction;
    use Soyer\View\Custom\Functions;


    /**
     * This is class store function for twig engine
     */
    class Template {


        /**
         * This is function create 
         * 
         * @param string $dir
         */
        public static function create($dir) {
            $loader = new TemplateFileSystemLoader($dir);
            $twig = new Environment($loader, []);

            // add custom function as a Twig function //
            $twig->addFunction(new TwigFunction('asset', [Functions::class, 'generateAssetUrl']));

            return $twig;
        }

    }