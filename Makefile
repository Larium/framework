docker-build:
	docker build -f .docker/php8.4-cli/Dockerfile -t framework-8.4 .
composer-update:
	docker run -v $(shell pwd):/opt/php framework-8.4 sh -c 'composer update'
run-tests:
	docker run -v $(shell pwd):/opt/php framework-8.4 sh -c './vendor/bin/phpunit tests/'
