<?php

namespace Tests;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Phinx\Wrapper\TextWrapper
     */
    public static $wrap = null;

    public static function setUpBeforeClass()
    {
        putenv('TESTING=TRUE');

        // setup phinx
        $app = new \Phinx\Console\PhinxApplication();
        self::$wrap = new \Phinx\Wrapper\TextWrapper($app);
        self::$wrap->setOption('environment', 'db');
        self::$wrap->setOption('configuration', 'phinx.php');
        self::$wrap->setOption('parser', 'php');

        // rollback migrate and seed the test database
        // rollback is just backup (i.e. when testing was interrupted), normally rollup should run at the end
        self::$wrap->getRollback(null, 0);
        self::$wrap->getMigrate();
        self::$wrap->getSeed();
    }

    public static function tearDownAfterClass()
    {

        // TODO remove this
        // Phinx TextWrapper throws an exception when calling rollback twice on the same instance.
        // I assume this is a bug in Phinx so as temporary workaround use a new instance.
        self::$wrap = null;
        self::$wrap = new \Phinx\Wrapper\TextWrapper(new \Phinx\Console\PhinxApplication());
        self::$wrap->setOption('environment', 'db');
        self::$wrap->setOption('configuration', 'phinx.php');
        self::$wrap->setOption('parser', 'php');
        // END TODO

        // rollback the test database as cleanup
        self::$wrap->getRollback(null, 0);
        self::$wrap = null;
    }
}
