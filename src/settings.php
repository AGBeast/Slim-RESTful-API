<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        //API settings
        'api' => [
            'version' => 'v1',
            'base_url' => 'https://localhost:8888',

        ],

        //Database settings
        'db' => [
            'host'=> 'localhost',
            'name' => 'store_db',
            'username' => 'root',
            'password' => ''
        ]
    ],
];
