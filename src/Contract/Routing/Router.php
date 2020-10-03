<?php

declare(strict_types = 1);

namespace Larium\Framework\Contract\Routing;

use Psr\Http\Message\ServerRequestInterface;

interface Router
{
    public function match(ServerRequestInterface $request): RequestArguments;
}
