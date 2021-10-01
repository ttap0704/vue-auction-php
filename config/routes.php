<?php

use Slim\App;

return function (App $app) {

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    $app->post('/users/join', \App\Action\User\UserCreateAction::class);
    $app->post('/users/login', \App\Action\User\UserLoginAction::class);
    $app->post('/users/cash', \App\Action\User\UserCashChargeAction::class);

    $app->get('/comunity/post', \App\Action\Post\PostGetAction::class);
    $app->get('/comunity/post/detail/{pid}', \App\Action\Post\PostDetailGetAction::class);
    $app->post('/comunity/post/add', \App\Action\Post\PostCreateAction::class);


    $app->post('/auction', \App\Action\Auction\AuctionCreateAction::class);
    $app->get('/auction/getauctionlist', \App\Action\Auction\AuctionGetListAction::class);
    $app->get('/auction/detail/{aid}', \App\Action\Auction\AuctionDetailGetAction::class);
    $app->post('/auction/hashtag', \App\Action\Auction\AuctionHashtagCreateAction::class);
    $app->post('/auction/addimages', \App\Action\Auction\AuctionImageAddAction::class);
    $app->post('/auction/updateimages', \App\Action\Auction\AuctionImageUpdateAction::class);
    $app->post('/auction/bid', \App\Action\Auction\AuctionBidAction::class);

    $app->post('/utils/upload', \App\Action\Util\UploadFilesAction::class);
};
