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
        'directory' => [
            'public_assets' => ROOT_DIR . DIRECTORY_SEPARATOR . 'public/assets',
            'profile_pictures' => ROOT_DIR . DIRECTORY_SEPARATOR . 'public/assets/img/profiles',
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
        'admin_notification_email' => [
            'recipients' => [
                [
                    'name' => 'SHARMIN SHANTA',
                    'email_address' => 'sharmin@previewtechs.com'
                ],
                /*[
                    'name' => 'PREVIEW TECHNOLOGIES LIMITED',
                    'email_address' => 'info@previewtechs.com'
                ]*/
            ],
            'cc' => [
                [
                    'name' => 'Sharmin Shanta',
                    'email_address' => 'shantaex81@gmail.com'
                ],
                [
                    'name' => 'Mim Ety Shanta',
                    'email_address' => 'mimetyshanta@gmail.com'
                ]
            ],
        ],
        'portal_admin' => [
            'sharmin@previewtechs.com'
        ],
        'send_email_api_endpint' => 'https://www.previewtechsapis.com/internal_email/v1/messages/queue?key=291b6bbc764382def82d64ff6b8225d4',
        'tinyMCE_api_key' => '9i61oreyc2qfdq8l2m5omf0w5a3omy4n38kixyn326oks43i',
        'gcaptcha' => [
            'backend_key' => '6LcWwTIUAAAAAOPmbptmwG6v_CDs2nMuqYF2vOtt',
            'site_key' => '6LcWwTIUAAAAAAVZ5bqEpkFlAmWskNQEopvJjJrI'
        ],
    ]
];