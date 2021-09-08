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
    $app->options('/comunity/post', function ($request, $response, $args) {
        return $response;
    });
    $app->options('/comunity/post/detail', function ($request, $response, $args) {
        return $response;
    });
    $app->options('/comunity/post/add', function ($request, $response, $args) {
        return $response;
    });

    $app->post('/users/join', \App\Action\UserCreateAction::class);
    $app->post('/users/login', \App\Action\UserLoginAction::class);
    $app->get('/comunity/post', \App\Action\PostGetAction::class);
    $app->get('/comunity/post/detail', \App\Action\PostDetailGetAction::class);
    $app->post('/comunity/post/add', \App\Action\PostCreateAction::class);
    
};