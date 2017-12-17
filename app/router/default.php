<?php

use Sharminshanta\Web\Accounts\Middleware\Auth;

$app->get('/', \Sharminshanta\Web\Accounts\Controller\DefaultController::class . ":testView");
$app->post('/testPostRoute', \Sharminshanta\Web\Accounts\Controller\DefaultController::class . ":testPost");
$app->get('/send-message', \Sharminshanta\Web\Accounts\Controller\DefaultController::class . ":createMessage")
    ->add(new Auth());
$app->post('/send-a-message', \Sharminshanta\Web\Accounts\Controller\DefaultController::class . ":saveMessage");