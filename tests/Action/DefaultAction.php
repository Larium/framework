<?php

declare(strict_types = 1);

namespace Larium\Action;

use Larium\Http\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DefaultAction implements Action
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return (new ResponseFactory())->createResponse();
    }
}
