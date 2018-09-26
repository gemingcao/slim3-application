<?php
return [
    'settings' => [
        'debug' => true,
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name'  => 'slim-app',
            'level' => Monolog\Logger::DEBUG,
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
        ],

        // Renderer settings
        'renderer'                          => [
            'templatePath'      => __DIR__ . '/../templates/',
            'templateCachePath' => __DIR__ . '/../caches/templates/',
        ],
        'determineRouteBeforeAppMiddleware' => false,

        //database settings
        'db'                                => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'slim3-application',
            'username'  => 'root',
            'password'  => '123456',
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => 'gmc_',
        ],
    ],
];
