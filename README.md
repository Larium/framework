# PSR-15 Framework

A lightweight PSR-15 compliant framework for building HTTP applications with middleware support and dependency injection.

## Requirements

- PHP 8.2, 8.3, or 8.4
- Composer
- Docker (for development environment)

## Installation

### As a Composer Package (Recommended)

Install the framework as a dependency in your project:

```bash
composer require larium/framework
```

### Development Setup

If you want to contribute to the framework or run it locally:

1. **Clone the repository:**
   ```bash
   git clone git@github.com:Larium/framework.git
   cd framework
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

## Development Environment

This project uses Docker for consistent development environments across different PHP versions.

### Using Make Commands

The project includes several make commands for common development tasks:

#### Docker Environment Setup
- `make docker-build` - Build Docker image for PHP 8.4
- `make docker-build-8.3` - Build Docker image for PHP 8.3  
- `make docker-build-8.2` - Build Docker image for PHP 8.2

#### Dependency Management
- `make composer-update` - Update dependencies using PHP 8.4 Docker container
- `make composer-update-8.3` - Update dependencies using PHP 8.3 Docker container
- `make composer-update-8.2` - Update dependencies using PHP 8.2 Docker container

#### Testing
- `make run-tests` - Run tests using PHP 8.4 Docker container
- `make run-tests-8.3` - Run tests using PHP 8.3 Docker container
- `make run-tests-8.2` - Run tests using PHP 8.2 Docker container

### Manual Setup (without Docker)

If you prefer to work without Docker:

1. **Install PHP 8.2+** with required extensions:
   - bcmath
   - zip
   - xdebug (for development)

2. **Install Composer** if not already installed:
   ```bash
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   ```

3. **Install dependencies:**
   ```bash
   composer install
   ```

4. **Run tests:**
   ```bash
   ./vendor/bin/phpunit tests/
   ```

## Usage Example

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
    /** @var ContainerProvider [implement the ContainerProvider interface] */
    $containerProvider
    $container = $containerProvider->getContainer();

    $f = new Framework($container);

    $f->pipe(RoutingMiddleware::class, 1);
    $f->pipe(ActionResolverMiddleware::class, 0);

    $f->run(ServerRequestFactory::fromGlobals());
})();
```

## Project Structure

- `src/` - Framework source code
- `tests/` - Test suite
- `.docker/` - Docker configuration for different PHP versions
- `build/` - Build artifacts and coverage reports
- `vendor/` - Composer dependencies

## Testing

Run the test suite using one of these methods:

**Using Make (recommended):**
```bash
make run-tests
```

**Using PHPUnit directly:**
```bash
./vendor/bin/phpunit tests/
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests: `make run-tests`
5. Submit a pull request

## License

MIT License - see LICENSE file for details.
