<?php

declare(strict_types = 1);

namespace Larium\Framework\Http;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;

class ServerRequestFactory implements ServerRequestFactoryInterface
{
    public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        if (class_exists('\Laminas\Diactoros\ServerRequestFactory')) {
            return (new \Laminas\Diactoros\ServerRequestFactory())
                ->createServerRequest($method, $uri, $serverParams);
        }

        throw new \RuntimeException('Unable to find a PSR-7 implementation');
    }
}
