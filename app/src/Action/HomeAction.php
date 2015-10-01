<?php

namespace App\Action;

use Psr\Log\LoggerInterface;

final class HomeAction
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function dispatch($request, $response, $args)
    {
        $this->logger->info('Home page action dispatched');

        $response->write('Hello, World!');

        return $response;
    }
}
