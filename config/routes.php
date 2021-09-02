<?php

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    $app->options('/users', function ($request, $response, $args) {
        return $response;
    });

    $app->post('/users', \App\Action\UserCreateAction::class);
};