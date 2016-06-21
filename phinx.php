<?php

// load database settings from app configuration to avoid configuration redundance
$app_settings = require __DIR__.'/app/settings.php';
$db_settings = $app_settings['settings']['db'];

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds',
    ],

    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'db',
        'db' => [
            'adapter' => $db_settings['driver'],
            'host' => $db_settings['host'],
            'name' => $db_settings['database'],
            'user' => $db_settings['username'],
            'pass' => $db_settings['password'],
            'port' => $db_settings['port'],
            'charset' => $db_settings['charset'],
        ],
    ],
];
