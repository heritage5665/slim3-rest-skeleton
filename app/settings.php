<?php

return [
    'settings' => [
        // database settings
        'database' => [
            'dsn' => 'mysql:host=localhost;dbname=notes',
            'username' => 'notes',
            'password' => 'notes',
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__.'/../log/app.log',
        ],
    ],
];
