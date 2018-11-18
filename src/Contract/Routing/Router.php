<?php

declare(strict_types = 1);

namespace Larium\Contract\Routing;

use Psr\Http\Message\ServerRequestInterface;

interface Router
{
    public function match(string $method, string $path): RequestArguments;
}
