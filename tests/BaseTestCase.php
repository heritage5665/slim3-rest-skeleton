<?php

namespace Tests;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Use middleware when running application?
     *
     * @var bool
     */
    protected $withMiddleware = true;

    /**
     * @var \Phinx\Wrapper\TextWrapper
     */
    public static $wrap = null;

    /**
     * Process the application given a request method and URI.
     *
     * @param string            $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string            $requestUri    the request URI
     * @param array|object|null $requestData   the request data
     *
     * @return \Slim\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri,
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();

        // Use the application settings
        $settings = require __DIR__.'/../app/settings.php';

        // use the database settings for testing
        $settings['settings']['db'] = $settings['settings']['db_testing'];

        // Instantiate the application
        $app = new App($settings);

        // Set up dependencies
        require __DIR__.'/../app/dependencies.php';

        // Register middleware
        if ($this->withMiddleware) {
            require __DIR__.'/../app/middleware.php';
        }

        // Register routes
        require __DIR__.'/../app/routes.php';

        // Process the application
        $response = $app->process($request, $response);

        // Return the response
        return $response;
    }

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
