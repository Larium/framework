<?php

declare(strict_types = 1);

namespace Larium\Framework\Middleware;

use Laminas\Diactoros\ServerRequest;
use Larium\Framework\Action\DefaultAction;
use Larium\Framework\Contract\Routing\RequestArguments;
use Larium\Framework\Contract\Routing\Router;
use Larium\Framework\Http\ResponseFactory;
use Larium\Framework\Http\ServerRequestFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RoutingMiddlewareTest extends TestCase
{
    public function testShouldMatchRoute(): void
    {
        $m = new RoutingMiddleware($this->getRouter(DefaultAction::class, ['page' => 1]));
        $request = (new ServerRequestFactory)->createServerRequest('GET', 'https://example.com/page/1');

        $m->process($request, $this->createRequestHandler());
    }

    public function testShouldHandleCallableAction(): void
    {
        $m = new RoutingMiddleware($this->getRouter(function(ServerRequestInterface $request) {
            return 'OK';
        }, ['page' => 1]));
        $request = (new ServerRequestFactory)->createServerRequest('GET', 'https://example.com/page/1');
        $m->process($request, $this->createRequestHandlerCallable());
    }

    /**
     * @param string|callable $action
     * @return MockObject|Router
     */
    private function getRouter($action, array $args)
    {
        $mock = $this->getMockBuilder(Router::class)
            ->onlyMethods(['match'])
            ->getMock();

        $requestArguments = new RequestArguments($action, $args);

        $mock->expects($this->once())
            ->method('match')
            ->willReturn($requestArguments);

        return $mock;
    }

    /**
     * @return MockObject|RequestHandlerInterface
     */
    private function createRequestHandler()
    {
        $mock = $this->getMockBuilder(RequestHandlerInterface::class)
            ->onlyMethods(['handle'])
            ->getMock();

        $mock->expects($this->once())
            ->method('handle')
            ->with($this->callback(function (ServerRequestInterface $r) {
                return $r->getAttribute('_action') === DefaultAction::class
                    && $r->getAttribute('page') === 1;
            }))
            ->willReturn((new ResponseFactory())->createResponse());

        return $mock;
    }

    /**
     * @return MockObject|RequestHandlerInterface
     */
    private function createRequestHandlerCallable()
    {
        $mock = $this->getMockBuilder(RequestHandlerInterface::class)
            ->onlyMethods(['handle'])
            ->getMock();

        $mock->expects($this->once())
            ->method('handle')
            ->with($this->callback(function (ServerRequestInterface $r) {
                return is_callable($r->getAttribute('_action'))
                    && $r->getAttribute('page') === 1;
            }))
            ->willReturn((new ResponseFactory())->createResponse());

        return $mock;
    }
}
