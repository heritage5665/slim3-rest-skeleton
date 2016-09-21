<?php

namespace UnitTests\Home;

use UnitTests\BaseUnitTestCase;
use Slim\Http\Response;
use Mockery as m;
use App\Action\HomeAction;

class HomeActionTest extends BaseUnitTestCase
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

        $home_action = new HomeAction($logger);

        $response = $home_action($request, $response, null);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Hello, World!', (string) $response->getBody());
    }
}
