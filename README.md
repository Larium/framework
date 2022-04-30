# PSR-15 framework

## Example
```php
<?php
# public/index.php

declare(strict_types = 1);

use Larium\Framework\Framework;
use Larium\Framework\Middleware\RoutingMiddleware;
use Laminas\Diactoros\ServerRequestFactory;
use Larium\Framework\Middleware\ActionResolverMiddleware;
use Larium\Framework\Provider\ContainerProvider;

require_once __DIR__ . '/../vendor/autoload.php';

(function () {
    $container = $containerProvider->getContainer();
    $framework = new Framework($container);

    $framework->pipe(RoutingMiddleware::class, 1);
    $framework->pipe(ActionResolverMiddleware::class, 0);

    $framework->run(ServerRequestFactory::fromGlobals());
})();

```
