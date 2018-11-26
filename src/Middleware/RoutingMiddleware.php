<?php

declare(strict_types = 1);

namespace Larium\Middleware;

use Larium\Contract\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RoutingMiddleware implements MiddlewareInterface
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $args = $this->router->match($request);

        $request = $request->withAttribute('_action', $args->getAction());

        foreach ($args->getArguments() as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }

        return $handler->handle($request);
    }
}
