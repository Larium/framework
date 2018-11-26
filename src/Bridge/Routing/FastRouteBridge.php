<?php

declare(strict_types = 1);

namespace Larium\Bridge\Routing;

use FastRoute\Dispatcher;
use Larium\Contract\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;
use Larium\Contract\Routing\RequestArguments;
use Larium\Contract\Routing\HttpNotFoundException;
use Larium\Contract\Routing\HttpMethodNotAllowedException;

class FastRouteBridge implements Router
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function match(ServerRequestInterface $request): RequestArguments
    {
        $routeInfo = $this->dispatcher->dispatch(
            $request->getMethod(),
            $request->getUri()->getPath()
        );
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new HttpNotFoundException();
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                throw new HttpMethodNotAllowedException();
                break;
            case Dispatcher::FOUND:
                return new RequestArguments($routeInfo[1], $routeInfo[2]);
        }
    }
}
