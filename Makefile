include .env

ROOT_DIR:=$(shell dirname $(realpath $(firstword $(MAKEFILE_LIST))))

# Build commands
all: down clear-cache-all build up composer-install db-migrate chmod-var-dir remove-build-containers
restart: down up
build:
	@echo "Building containers"
	@docker compose --env-file .env build
up:
	@echo "Starting containers"
	@docker compose --env-file .env up -d --remove-orphans
down:
	@echo "Stopping containers"
	@docker compose --env-file .env down
	@rm -rf public/assets
node-build:
	@echo "Running npm build"
	@docker compose --profile build run --rm node npm run build
node-dev:
	@echo "Starting Vite dev server"
	@docker compose --profile build run --rm node npm run dev
logs:
	@echo "Showing logs"
	@docker compose logs -f
composer-install:
	@echo "Running composer install"
	@docker exec ${APP_NAME}.service.app composer install
composer-update:
	@echo "Running composer update"
	@docker exec ${APP_NAME}.service.app composer update
chmod-var-dir:
	@echo "Setting permissions on var"
	@sudo chmod -R 777 var
remove-build-containers:
ifeq ($(NODE_MODE), build)
	@echo "Waiting for ${APP_NAME}.service.node to stop..."
	@docker wait ${APP_NAME}.service.node > /dev/null 2>&1
	@echo "Removing ${APP_NAME}.service.node container..."
	@docker rm ${APP_NAME}.service.node > /dev/null 2>&1
else
	@echo "Skipping ${APP_NAME}.service.node removal. NODE_MODE is ${NODE_MODE}."
endif

# Database commands
db-migrate:
	@echo "Running database migrations"
	@docker exec -u www-data ${APP_NAME}.service.app php bin/console --no-interaction doctrine:migration:migrate
db-migration-generate:
	@echo "Running database migration generate"
	@docker exec -u www-data ${APP_NAME}.service.app php bin/console --no-interaction doctrine:migration:generate
db-migration-rollback:
	@echo "Running database migration rollback"
	@docker exec -u www-data ${APP_NAME}.service.app php bin/console --no-interaction doctrine:migrations:migrate prev

clear-cache:
	@echo "Clearing global cache"
	@docker exec -u www-data ${APP_NAME}.service.app php bin/console --no-interaction cache:pool:clear cache.global_clearer
clear-all: clear-cache-all clear-logs-all
clear-cache-all:
	@echo "Clearing all cache"
	@sudo rm -rf var/cache/*
clear-logs-all:
	@echo "Clearing all logs"
	@sudo rm -rf var/log/*
