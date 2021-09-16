<?php
use Slim\App;

return function (App $app) {

    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    $app->post('/users/join', \App\Action\UserCreateAction::class);
    $app->post('/users/login', \App\Action\UserLoginAction::class);
    $app->post('/users/cash', \App\Action\UserCashChargeAction::class);
    $app->get('/comunity/post', \App\Action\PostGetAction::class);
    $app->get('/comunity/post/detail/{pid}', \App\Action\PostDetailGetAction::class);
    $app->post('/comunity/post/add', \App\Action\PostCreateAction::class);

    $app->post('/utils/upload', \App\Action\UploadFilesAction::class);
};