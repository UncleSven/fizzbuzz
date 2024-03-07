.PHONY: docker-bash
docker-bash: # Enters laravel-app container and runs bash-script.
	docker exec -it laravel-app /bin/bash

.PHONY: docker-start
docker-start: # Starts existing containers for a service.
	./vendor/bin/sail up -d

.PHONY: docker-stop
docker-stop: # Stops running containers without removing them.
	./vendor/bin/sail stop

.PHONY: env
env: # Makes the .env-file with default values.
	cp .env.example .env

.PHONY: fizzbuzz
fizzbuzz:
	docker exec laravel-app php artisan app:fizz-buzz

.PHONY: setup
setup:
	chmod +x .docker/pre-installation.sh && \
	./.docker/pre-installation.sh && \
	./vendor/bin/sail up -d && \
	docker exec laravel-app php artisan key:generate && \
	./vendor/bin/sail up -d # restart to activate the app_key for feature-tests

.PHONY: static
static:
	docker exec -it laravel-app vendor/bin/phpstan analyse

.PHONY: tests
tests:
	docker exec laravel-app php artisan test --testsuite=Unit,Integration,Feature

.PHONY: vendor-install
vendor-install: # Enters laravel-app container and runs composer install
	docker exec laravel-app composer install

.PHONY: vendor-update
vendor-update: # Enters laravel-app container and runs composer update
	docker exec laravel-app composer update
