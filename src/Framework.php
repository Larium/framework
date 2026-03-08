<?php

declare(strict_types = 1);

namespace Larium\Framework;

use SplPriorityQueue;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Larium\Framework\Http\ResponseSender;
use Psr\Http\Message\ServerRequestInterface;
use Larium\Framework\RequestHandler\RequestHandler;
use Larium\Framework\RequestHandler\ContainerMiddlewareResolver;
use Psr\Http\Message\ResponseInterface;

final class Framework
{
    /**
     * @var SplPriorityQueue
     */
    private $entries;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->entries = new SplPriorityQueue();
        $this->container = $container;
    }

    /**
     * @param string|MiddlewareInterface $middleware
     * @param int $priority
     */
    public function pipe($middleware, int $priority = 0): void
    {
        $this->entries->insert($middleware, $priority);
    }

    public function run(ServerRequestInterface $request): void
    {
        $response = $this->getResponse($request);

        echo ResponseSender::new($response)->send();
    }

    public function getResponse(ServerRequestInterface $request): ResponseInterface
    {
        $requestHandler = new RequestHandler(
            $this->entries,
            new ContainerMiddlewareResolver($this->container)
        );

        return $requestHandler->handle($request);
    }
}
