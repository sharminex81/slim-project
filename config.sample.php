<?php
return [
    'app' => [
        'site_url' => '',
        'accounts_portal_url' => '',
        'mode' => 1,
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header,
        'error_reporting' => 1,
        'renderer' => [
            'template_path' => ROOT_DIR . DIRECTORY_SEPARATOR . 'templates/',
        ],
        'view' => [
            'template_path' => ROOT_DIR . DIRECTORY_SEPARATOR . 'templates/',
            'twig' => [
                'cache' => false,
                'debug' => true,
                'auto_reload' => true,
            ],
        ],
        'logger' => [
            'name' => 'slim-project',
            'path' => ROOT_DIR . DIRECTORY_SEPARATOR . 'logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
            'monolog_handlers' => ['php://stdout', 'file']
        ],
        'databases' => [
            'default' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => '',
                'username' => 'e',
                'password' => '',
                'charset' => 'Utf8',
                'collation' => 'utf8_general_ci',
                'prefix' => '',
                'unix_socket' => null
            ],
        ],
    ]
];