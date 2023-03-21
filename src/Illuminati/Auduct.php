<?php

    namespace Illuminati;

    use Illuminati\Routing\BaseRouter;

    class Auduct extends BaseRouter{

        // This class use BaseRouter

        function __construct($templates_path="/templates") {
            $GLOBALS["templates_path"] = $templates_path;
        }

    }