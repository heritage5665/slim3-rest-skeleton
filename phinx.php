<?php

// load database settings from app configuration to avoid configuration redundance
$app_settings = require __DIR__.'/app/settings.php';
$db_settings = $app_settings['settings']['db'];

// if TESTING environment flag is set use the testing database
if (getenv('TESTING') !== false) {
    $db_settings = $app_settings['settings']['db_testing'];
}

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'.((getenv('TESTING') !== false) ? '_testing' : ''),
    ],

    // This configuration is only used by thinx for a dummy db connection.
    // We are using eloquent in the migrations and seeds, which has its own db connection.
    // The eloquent db connection is set up in the InitCapsuleTrait.
    'environments' => [
        'default_migration_table' => 'phinxlog'.((getenv('TESTING') !== false) ? '_testing' : ''),
        'default_database' => 'db',
        'db' => [
            'adapter' => $db_settings['driver'],
            'host' => $db_settings['host'],
            'name' => $db_settings['database'],
            'user' => $db_settings['username'],
            'pass' => $db_settings['password'],
            'port' => $db_settings['port'],
            'charset' => $db_settings['charset'],
            'table_prefix' => $db_settings['prefix'],
        ],
    ],
];
