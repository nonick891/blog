# Variables
COMPOSE_FILE := ./infrastructure/compose.yml
DB_USER?=root
DB_PASSWORD?=root

# .PHONY ensures make doesn't look for files named like these targets
.PHONY: up down rebuild logs ps logs-php logs-nginx logs-mysql

up:
	docker compose -f $(COMPOSE_FILE) up -d

down:
	docker compose -f $(COMPOSE_FILE) down

rebuild:
	docker compose -f $(COMPOSE_FILE) up -d --build

composer-install:
	docker compose -f $(COMPOSE_FILE) run --rm php composer install --no-interaction

logs:
	docker compose -f $(COMPOSE_FILE) logs -f --tail=100

logs-php:
	docker compose -f $(COMPOSE_FILE) logs -f php

logs-nginx:
	docker compose -f $(COMPOSE_FILE) logs -f nginx

logs-mysql:
	docker compose -f $(COMPOSE_FILE) logs -f mysql

mysql-cli:
	docker compose -f infrastructure/compose.yml exec db mysql -u$(DB_USER) -p$(DB_PASSWORD)