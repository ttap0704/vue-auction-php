<?php
use Slim\App;

return function (App $app) {

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    $app->post('/users/join', \App\Action\UserCreateAction::class);
    $app->post('/users/login', \App\Action\UserLoginAction::class);
    $app->post('/users/cash', \App\Action\UserCashChargeAction::class);

    $app->get('/comunity/post', \App\Action\PostGetAction::class);
    $app->get('/comunity/post/detail/{pid}', \App\Action\PostDetailGetAction::class);
    $app->post('/comunity/post/add', \App\Action\PostCreateAction::class);


    $app->post('/auction', \App\Action\AuctionCreateAction::class);
    $app->get('/auction/getauctionlist', \App\Action\AuctionGetListAction::class);
    $app->get('/auction/detail/{aid}', \App\Action\AuctionDetailGetAction::class);
    $app->post('/auction/hashtag', \App\Action\AuctionHashtagCreateAction::class);
    $app->post('/auction/addimages', \App\Action\AuctionImageAddAction::class);
    $app->post('/auction/updateimages', \App\Action\AuctionImageUpdateAction::class);

    $app->post('/utils/upload', \App\Action\UploadFilesAction::class);
};