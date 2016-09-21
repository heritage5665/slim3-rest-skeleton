<?php

namespace UnitTests;

use Slim\Http\Request;
use Slim\Http\Environment;
use Tests\BaseTestCase;
use Illuminate\Database\Capsule\Manager as Capsule;

class BaseUnitTestCase extends BaseTestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // Boot eloquent
        $settings = require __DIR__.'/../../app/settings.php';

        $capsule = new Capsule();
        $capsule->addConnection($settings['settings']['db_testing']);

        //$capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * @param string            $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string            $requestUri    the request URI
     * @param array|object|null $requestData   the request data
     *
     * @return \Slim\Http\Response
     */
    public function createRequest($requestMethod, $requestUri, $requestData = null)
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

        return $request;
    }
}
