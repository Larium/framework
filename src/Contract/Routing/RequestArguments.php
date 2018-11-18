<?php

declare(strict_types = 1);

namespace Larium\Contract\Routing;

interface RequestArguments
{
    public function getAction(): string;

    public function getArguments(): array;
}
