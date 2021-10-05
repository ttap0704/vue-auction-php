<?php

use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use App\Middleware\CorsMiddleware;
use Odan\Session\Middleware\SessionMiddleware;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    $app->add(CorsMiddleware::class);
    $app->add(SessionMiddleware::class);

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    $app->add(BasePathMiddleware::class);
    $app->add(ErrorMiddleware::class);
};
