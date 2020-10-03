<?php

declare(strict_types = 1);

namespace Larium\Framework\Provider;

use Psr\Container\ContainerInterface;

interface ContainerProvider
{
    public function getContainer(): ContainerInterface;
}
