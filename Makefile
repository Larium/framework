docker-build:
	docker build -f .docker/php8.4-cli/Dockerfile -t framework-8.4 .
composer-update:
	docker run --rm -v $(shell pwd):/opt/php framework-8.4 sh -c 'composer update'
run-tests:
	docker run --rm -v $(shell pwd):/opt/php framework-8.4 sh -c './vendor/bin/phpunit tests/'
docker-build-8.3:
	docker build -f .docker/php8.4-cli/Dockerfile -t framework-8.3 .
composer-update-8.3:
	docker run --rm -v $(shell pwd):/opt/php framework-8.3 sh -c 'composer update'
run-tests-8.3:
	docker run --rm -v $(shell pwd):/opt/php framework-8.3 sh -c './vendor/bin/phpunit tests/'
docker-build-8.2:
	docker build -f .docker/php8.4-cli/Dockerfile -t framework-8.2 .
composer-update-8.2:
	docker run --rm -v $(shell pwd):/opt/php framework-8.2 sh -c 'composer update'
run-tests-8.2:
	docker run --rm -v $(shell pwd):/opt/php framework-8.2 sh -c './vendor/bin/phpunit tests/'
