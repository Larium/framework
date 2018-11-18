<?php

declare(strict_types = 1);

namespace Larium\RequestHandler;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

class ContainerMiddlewareResolver implements MiddlewareResolver
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($entry): MiddlewareInterface
    {
        if (is_string($entry)) {
            $entry = $this->container->get($entry);
        }

        if (is_object($entry) && $entry instanceof MiddlewareInterface) {
            return $entry;
        }

        throw new \RuntimeException(
            sprintf('Queue entries must be instances of %s', MiddlewareInterface::class)
        );
    }
}
