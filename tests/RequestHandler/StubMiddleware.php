<?php

declare(strict_types = 1);

namespace Larium\Framework\RequestHandler;

use Larium\Framework\Http\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StubMiddleware implements MiddlewareInterface
{
    public $int = 0;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->int ++;

        return (new ResponseFactory())->createResponse();
    }
}
