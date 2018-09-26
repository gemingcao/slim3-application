<?php
return [
    'app_id'   => 'your_app_id',
    'secret'   => 'your_secret',
    'token'    => 'your_token',
    'aes_key'  => 'your_aes_key',

    'response_type' => 'array',
    'log'     => [
        'level' => 'debug',
        'file'  => __DIR__ . '/../logs/easywechat.log',
    ],
    'oauth'   => [
        'scopes'   => ['snsapi_login'],
        'callback' => 'callback',
    ]
];
