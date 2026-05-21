include .env
export

.DEFAULT_GOAL := help

# Variables
COMPOSE_FILE := ./infrastructure/compose.yml
DB_USER?=root
DB_PASSWORD?=root

# .PHONY ensures make doesn't look for files named like these targets
.PHONY: up down rebuild logs ps logs-php logs-nginx logs-mysql mysql-cli lint fix phpstan migrate reset seed refresh truncate composer-install

# Dev environment

## run docker images with compose file
up:
	docker compose -f $(COMPOSE_FILE) up -d --remove-orphans

## down docker images with compose file
down:
	docker compose -f $(COMPOSE_FILE) down

## rebuild docker images with compose file
rebuild:
	docker compose -f $(COMPOSE_FILE) up -d --build --remove-orphans

## run composer install in php docker image
composer-install:
	docker compose -f $(COMPOSE_FILE) exec php composer install --no-interaction

# Logs

## logs from all docker images
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

# Linter tools

## Show php code style errors
lint:
	docker compose -f $(COMPOSE_FILE) exec php composer lint

## Fix php style code errors
fix:
	docker compose -f $(COMPOSE_FILE) exec php composer fix

## Run static analysis on php code
phpstan:
	docker compose -f $(COMPOSE_FILE) exec php vendor/bin/phpstan analyse --memory-limit=512M

### Migrations

## database command
migrate reset seed refresh truncate:
	docker compose -f $(COMPOSE_FILE) exec php php core/commands.php $@

## This help command
help:
	@awk '/^#/ {comment=$$0; next} \
	/^[a-zA-Z0-9 _-]+:/ && !/:=/ && !/=/ { \
		gsub(/^#[# ]*/, "", comment); \
		split($$0, targets, ":"); \
		n = split(targets[1], names, " "); \
		for (i=1; i<=n; i++) { \
			if (names[i] != "help") { \
				printf "\033[36m%-20s\033[0m \033[90m%s\033[0m\n", names[i], comment \
			} \
		} \
	} \
	{comment=""}' Makefile