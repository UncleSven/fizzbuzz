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

.PHONY: post-setup
post-setup:
	docker exec laravel-app php artisan key:generate

.PHONY: pre-setup
pre-setup:
	chmod +x .docker/pre-installation.sh && \
	./.docker/pre-installation.sh

.PHONY: setup
setup: pre-setup docker-start post-setup

.PHONY: vendor-install
vendor-install: # Enters laravel-app container and runs composer install
	docker exec laravel-app composer install

.PHONY: vendor-update
vendor-update: # Enters laravel-app container and runs composer update
	docker exec laravel-app composer update
