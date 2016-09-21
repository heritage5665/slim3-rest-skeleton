<?php

namespace UnitTests\Home;

use UnitTests\BaseUnitTestCase;
use Slim\Http\Response;
use Mockery as m;
use App\Controller\HomeController;

class HomeControllerTest extends BaseUnitTestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetHome()
    {
        $request = $this->createRequest('GET', '/');
        $response = new Response();

        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('info');

        $home_controller = new HomeController($logger);

        $response = $home_controller($request, $response, null);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Hello, World!', (string) $response->getBody());
    }
}
