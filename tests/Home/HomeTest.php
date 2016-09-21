<?php

namespace Tests\Home;

use Tests\BaseTestCase;

class HomeTest extends BaseTestCase
{
    public function testGetHome()
    {
        $response = $this->runApp('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Hello, World!', (string) $response->getBody());
    }
}
