### Example

```php
<?php

declare(strict_types = 1);

use Larium\Framework;
use Larium\Middleware\RoutingMiddleware;
use Laminas\Diactoros\ServerRequestFactory;
use Larium\Middleware\ActionResolverMiddleware;
use Larium\Framework\Provider\ContainerProvider;

require_once __DIR__ . '/../vendor/autoload.php';

(function () {
    /** @var ContainerProvider */
    $containerProvider
    $container = $containerProvider->getContainer().

    $f = new Framework($container);

    $f->pipe(RoutingMiddleware::class, 1);
    $f->pipe(ActionResolverMiddleware::class, 0);

    $f->run(ServerRequestFactory::fromGlobals());
})();

```
