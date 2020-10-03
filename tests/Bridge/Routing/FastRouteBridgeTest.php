<?php

declare(strict_types = 1);

namespace Larium\Framework\Bridge\Routing;

use FastRoute\RouteCollector;
use Larium\Framework\Contract\Routing\HttpMethodNotAllowedException;
use Larium\Framework\Contract\Routing\HttpNotFoundException;
use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\ServerRequestFactory;
use function FastRoute\simpleDispatcher;

class FastRouteBridgeTest extends TestCase
{
    public function testHttpNotFoundException(): void
    {
        $this->expectException(HttpNotFoundException::class);
        $this->expectExceptionMessage("Requested path not found");
        $this->expectExceptionCode(404);
        $request = (new ServerRequestFactory())->createServerRequest("GET", "https://example.com");
        $dispatcher = simpleDispatcher(function () {
        });

        $router = new FastRouteBridge($dispatcher);
        $router->match($request);
    }

    public function testHttpMethodNotAllowedException(): void
    {
        $this->expectException(HttpMethodNotAllowedException::class);
        $this->expectExceptionMessage("Only `POST` methods are allowed");
        $this->expectExceptionCode(405);
        $request = (new ServerRequestFactory())->createServerRequest("GET", "https://example.com/resource");
        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            $r->addRoute('POST', '/resource', function () {
            });
        });

        $router = new FastRouteBridge($dispatcher);
        $router->match($request);
    }
}
