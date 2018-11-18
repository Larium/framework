<?php

declare(strict_types = 1);

namespace Larium\Http;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

class ResponseFactory implements ResponseFactoryInterface
{
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        if (class_exists('\Zend\Diactoros\ResponseFactory')) {
            return (new \Zend\Diactoros\ResponseFactory())
                ->createResponse($code, $reasonPhrase);
        }

        throw new \RuntimeException('Unable to find a PSR-7 implementation');
    }
}
