<?php

declare(strict_types = 1);

namespace Larium\Framework\RequestHandler;

use SplPriorityQueue;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var SplPriorityQueue
     */
    private $queue;

    /**
     * @var MiddlewareResolver
     */
    private $resolver;

    public function __construct(SplPriorityQueue $entries, MiddlewareResolver $resolver = null)
    {
        $this->queue = $entries;

        if ($resolver === null) {
            $resolver = new class() implements MiddlewareResolver {
                public function resolve($entry): MiddlewareInterface
                {
                    return $entry;
                }
            };
        }

        $this->resolver = $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->queue->isEmpty()) {
            throw new EmptyQueueException('Unable to handle an empty queue');
        }

        $this->queue->rewind();
        $entry = $this->queue->current();
        $middleware = $this->resolver->resolve($entry);
        $this->queue->next();

        return $middleware->process($request, $this);
    }
}
