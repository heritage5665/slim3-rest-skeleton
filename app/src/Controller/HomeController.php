<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class HomeController.
 */
final class HomeController
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     *
     * @return \Slim\Http\Response
     */
    public function __invoke(Request $request, Response $response, $args)
    {
        $this->logger->info('HomeController dispatched');

        $response->write('Hello, World!');

        return $response;
    }
}
