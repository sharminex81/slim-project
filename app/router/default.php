<?php

use Sharminshanta\Web\Accounts\Middleware\AdminMiddleware;
use Sharminshanta\Web\Accounts\Middleware\AuthMiddleware;

$app->get('/', \Sharminshanta\Web\Accounts\Controller\DefaultController::class . ":testView")
    ->add(new AdminMiddleware($app->getContainer()));
$app->post('/testPostRoute', \Sharminshanta\Web\Accounts\Controller\DefaultController::class . ":testPost");
$app->get('/send-message', \Sharminshanta\Web\Accounts\Controller\DefaultController::class . ":createMessage")
    ->add(new AuthMiddleware($app->getContainer()));
$app->post('/send-a-message', \Sharminshanta\Web\Accounts\Controller\DefaultController::class . ":saveMessage");