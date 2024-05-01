build:
	docker build -f .docker/php8.3-cli/Dockerfile -t framework-8.3 .
composer-update:
	docker run -v $(shell pwd):/opt/php framework-8.3 sh -c 'composer update'
run-tests:
	docker run -v $(shell pwd):/opt/php framework-8.3 sh -c './vendor/bin/phpunit tests/'
