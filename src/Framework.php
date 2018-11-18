<?php

declare(strict_types = 1);

namespace Larium;

use Larium\Http\ResponseSender;
use Larium\RequestHandler\ContainerMiddlewareResolver;
use Larium\RequestHandler\RequestHandler;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface;
use SplPriorityQueue;
use Psr\Container\ContainerInterface;
use Larium\Http\ServerRequestFactory;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;

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
        $requestHandler = new RequestHandler(
            $this->entries,
            new ContainerMiddlewareResolver($this->container)
        );

        $response = $requestHandler->handle($request);

        echo ResponseSender::new($response)->send();
    }
}
