<?php

declare(strict_types = 1);

namespace Larium\RequestHandler;

use Larium\Http\ServerRequestFactory;
use SplPriorityQueue;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class RequestHandlerTest extends TestCase
{
    public function testShouldHandleRequest(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest("GET", "https://example.com");

        $stub = new StubMiddleware();
        $queue = new SplPriorityQueue();
        $queue->insert($stub, 0);
        $handler = new RequestHandler($queue);

        $response = $handler->handle($request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(1, $stub->int);
    }

    public function testShouldPassRequestToHandler(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest("GET", "https://example.com");
        $queue = new SplPriorityQueue();
        $stub = new StubMiddleware();
        $queue->insert($stub, 1);
        $queue->insert(new NullMiddleware(), 0);
        $handler = new RequestHandler($queue);

        $response = $handler->handle($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(1, $stub->int);
    }

    /**
     * @expectedException Larium\RequestHandler\EmptyQueueException
     */
    public function testShouldThrowExceptionForEmptyQueue()
    {
        $request = (new ServerRequestFactory())->createServerRequest("GET", "https://example.com");
        $queue = new SplPriorityQueue();
        $handler = new RequestHandler($queue);

        $handler->handle($request);
    }
}
