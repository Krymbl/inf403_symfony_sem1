<?php

declare(strict_types=1);

use Ls_02_Hw_01\Controller\ErrorController;
use Ls_02_Hw_01\Core\Config;

require __DIR__.'/../vendor/autoload.php';

define("ROOT_DIR", dirname(__DIR__));
$routes = require ROOT_DIR."/config/routes.php";

session_start();

try {
    Config::load(ROOT_DIR);

    $uri = $_SERVER["REQUEST_URI"];
    $path = parse_url($uri, PHP_URL_PATH);
    $method = $_SERVER["REQUEST_METHOD"];

    $handler = $routes[$method][$path] ?? null;

    if ($handler !== null) {
        $controller = new $handler["controller"]();
        echo $controller->{$handler["action"]}();
    } else {
        http_response_code(404);
        echo ErrorController::notFound();
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo ErrorController::internalError($e->getMessage());
}


