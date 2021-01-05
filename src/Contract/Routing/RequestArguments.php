<?php

declare(strict_types = 1);

namespace Larium\Framework\Contract\Routing;

class RequestArguments
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * @var string|callable
     */
    private $action;

    /**
     * @param string|callable $action
     */
    public function __construct($action, array $arguments)
    {
        $this->action = $action;
        $this->arguments = $arguments;
    }

    /**
     * @return string|callable
     */
    public function getAction()
    {
        return $this->action;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }
}
