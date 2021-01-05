<?php

declare(strict_types = 1);

namespace Larium\Framework\Action;

use Larium\Framework\Http\Action;
use Psr\Http\Message\ResponseInterface;
use Larium\Framework\Http\ResponseFactory;
use Psr\Http\Message\ServerRequestInterface;

class DefaultAction implements Action
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return (new ResponseFactory())->createResponse();
    }
}
