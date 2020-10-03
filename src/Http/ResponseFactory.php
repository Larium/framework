<?php

declare(strict_types = 1);

namespace Larium\Framework\Http;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

class ResponseFactory implements ResponseFactoryInterface
{
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        if (class_exists('\Laminas\Diactoros\ResponseFactory')) {
            return (new \Laminas\Diactoros\ResponseFactory())
                ->createResponse($code, $reasonPhrase);
        }

        throw new \RuntimeException('Unable to find a PSR-7 implementation');
    }
}
