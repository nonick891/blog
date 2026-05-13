include .env
export

# Variables
COMPOSE_FILE := ./infrastructure/compose.yml
DB_USER?=root
DB_PASSWORD?=root

# .PHONY ensures make doesn't look for files named like these targets
.PHONY: up down rebuild logs ps logs-php logs-nginx logs-mysql mysql-cli lint fix phpstan commands composer-install

up:
	docker compose -f $(COMPOSE_FILE) up -d --remove-orphans

down:
	docker compose -f $(COMPOSE_FILE) down

rebuild:
	docker compose -f $(COMPOSE_FILE) up -d --build --remove-orphans

composer-install:
	docker compose -f $(COMPOSE_FILE) exec php composer install --no-interaction

logs:
	docker compose -f $(COMPOSE_FILE) logs -f --tail=100

logs-php:
	docker compose -f $(COMPOSE_FILE) logs -f php

logs-nginx:
	docker compose -f $(COMPOSE_FILE) logs -f nginx

logs-mysql:
	docker compose -f $(COMPOSE_FILE) logs -f mysql

mysql-cli:
	docker compose -f $(COMPOSE_FILE) exec db mysql -u$(DB_USER) -p$(DB_PASSWORD)

lint:
	docker compose -f $(COMPOSE_FILE) exec php composer lint

fix:
	docker compose -f $(COMPOSE_FILE) exec php composer fix

phpstan:
	docker compose -f $(COMPOSE_FILE) exec php vendor/bin/phpstan analyse

commands:
	docker compose -f $(COMPOSE_FILE) exec php php core/commands.php $(CMD)
