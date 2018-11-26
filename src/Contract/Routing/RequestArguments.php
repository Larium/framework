<?php

declare(strict_types = 1);

namespace Larium\Contract\Routing;

class RequestArguments
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * @var string
     */
    private $action;

    public function __construct(string $action, array $arguments)
    {
        $this->action = $action;
        $this->arguments = $arguments;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }
}
