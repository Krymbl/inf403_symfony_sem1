<?php

use Hw_03\Controller\GreetingController;
use Hw_03\Controller\RegistrationController;

return [
    "GET" => [
        "/" => [
            "controller" => GreetingController::class,
            "action" => "index"
        ],
        "/greeting" => [
            "controller" => GreetingController::class,
            "action" => "index"
        ],
        "/register" => [
            "controller" => RegistrationController::class,
            "action" => "showForm"
        ],
    ],
    "POST" => [
        "/register" => [
            "controller" => RegistrationController::class,
            "action" => "register"
        ],
        "/logout" => [
            "controller" => RegistrationController::class,
            "action" => "logout"
        ],
    ],
];