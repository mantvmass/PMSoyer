<?php

    namespace Soyer\Routing\Middleware;

    class ActiveMiddleware {

        private $middlewares = [];  // เก็บ middleware ในลำดับที่ต้องการให้ทำงาน
        private $handler;           // ฟังก์ชันหลักที่จะถูกเรียกใช้งาน

        public function __construct($middlewares) {
            $this->middlewares = $middlewares;
        }

        public function setTarget($handler) {
            $this->handler = $handler;
        }

        public function run($params) {
            $next = $this->handler;
            for ($i = count($this->middlewares) - 1; $i >= 0; $i--) {
                $currentMiddleware = $this->middlewares[$i];
                $next = function () use ($currentMiddleware, $next) {
                    $currentMiddleware::handle($next);  // เรียกใช้งาน middleware และส่งต่อฟังก์ชัน $next ต่อไปในลำดับถัดไป
                };
            }
            $next(...$params);  // เรียกใช้งานฟังก์ชันหลัก
        }
    }
?>