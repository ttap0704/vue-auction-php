<?php

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    $app->options('/users/login', function ($request, $response, $args) {
        return $response;
    });
    $app->options('/users/join', function ($request, $response, $args) {
        return $response;
    });
    $app->options('/comunity/post/add', function ($request, $response, $args) {
        return $response;
    });

    $app->post('/users/join', \App\Action\UserCreateAction::class);
    $app->post('/users/login', \App\Action\UserLoginAction::class);
    $app->post('/comunity/post/add', \App\Action\PostCreateAction::class);
};