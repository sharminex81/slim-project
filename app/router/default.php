<?php

$app->get('/', \Sharminshanta\Web\Accounts\Controller\DefaultController::class . ":testView");
$app->post('/testPostRoute', \Sharminshanta\Web\Accounts\Controller\DefaultController::class . ":testPost");