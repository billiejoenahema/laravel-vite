## Container structures

├── app
├── web
├── db
└── mailhog

### app container

- Base image
  - php:8.1-fpm-bullseye
  - composer:2.2

### web container

- Base image
  - nginx:1.20

### db container

- Base image
  - mysql/mysql-server:8.0
- architecture
  - Laravel 10.0
  - Vue 3.2
  - Vuex
  - Vue-router
  - Docker
  - nginx 1.2
  - MySQL 8.0

## Authentication

Sanctum with Cookie.

## commands

```bash
# ide-helper 実行
docker-compose exec app php artisan ide-helper:models --write

# PHPStan 実行
docker-compose exec app ./vendor/bin/phpstan analyse
```
