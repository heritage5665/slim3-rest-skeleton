<?php

namespace Database;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Trait InitCapsuleTrait.
 * Code parts from: <https://siipo.la/blog/how-to-use-eloquent-orm-migrations-outside-laravel>.
 */
trait InitCapsuleTrait
{
    /**
     * @var \Illuminate\Database\Capsule\Manager
     */
    public $capsule;

    /**
     * @var \Illuminate\Database\Schema\Builder
     */
    public $schema;

    /**
     * init.
     */
    public function init()
    {
        date_default_timezone_set('UTC');

        $app_settings = require __DIR__.'/../app/settings.php';
        $db_settings = $app_settings['settings']['db'];
        if (getenv('TESTING') !== false) {
            $db_settings = $app_settings['settings']['db_testing'];
        }

        $this->capsule = new Capsule();
        $this->capsule->addConnection($db_settings);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }
}
