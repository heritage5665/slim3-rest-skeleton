<?php

namespace IntegrationTests\Home;

use IntegrationTests\BaseIntegrationTestCase;

class HomeTest extends BaseIntegrationTestCase
{
    public function testGetHome()
    {
        $response = $this->runApp('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Hello, World!', (string) $response->getBody());
    }
}
