# PHP Blog

A blog engine built with PHP 8.4, MySQL 8.4, Nginx, and Smarty templating.

## Requirements

- Docker & Docker Compose

## Quick Start

```bash
# Copy env file
cp .env.example .env

# Start docker
make up

# Install composer dependencies
make composer-install

# Run migrations
make migrate

# Seed database
make seed
```

The app will be available at [http://localhost:8080](http://localhost:8080).

## Commands

### Dev environment

| Command | Description |
|---|---|
| `make up` | Start containers in background |
| `make down` | Stop containers |
| `make rebuild` | Rebuild and start containers |
| `make composer-install` | Install PHP dependencies |

### Database migrations

| Command | Description |
|---|---|
| `make migrate` | Run pending migrations |
| `make reset` | Roll back all migrations |
| `make seed` | Seed the database |
| `make refresh` | Roll back all, then migrate |
| `make truncate` | Truncate all tables |
