<?php

declare(strict_types = 1);

namespace Larium\Framework\Middleware;

use Larium\Framework\Framework;

interface MiddlewareBuilder
{
    public function build(Framework $f): void;
}
