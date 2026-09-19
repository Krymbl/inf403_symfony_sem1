<?php

use Ls_02_Hw_01\Controller\WeatherController;

return [
    "GET" => [
        "/" => [
            "controller" => WeatherController::class,
            "action" => "index",
        ],
        "/getweather" => [
            "controller" => WeatherController::class,
            "action" => "getFromApi",
        ],
    ],
];