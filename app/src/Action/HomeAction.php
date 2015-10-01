<?php

namespace App\Action;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class HomeAction
 *
 * @package App\Action
 */
final class HomeAction
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;


    /**
     * @param \Psr\Log\LoggerInterface $logger
     */    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->logger->info('Home page action dispatched');

        $response->write('Hello, World!');

        return $response;
    }
}
