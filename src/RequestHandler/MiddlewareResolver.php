<?php

declare(strict_types = 1);

namespace Larium\Framework\RequestHandler;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareResolver
{
    /**
     * @param string|MiddlewareInterface $entry
     */
    public function resolve($entry): MiddlewareInterface;
}
