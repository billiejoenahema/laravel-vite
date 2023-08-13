## Container structures

├── app
├── web
└── db

### app container

- Base image
  - php:8.1-fpm-buster
  - composer:2.2

### web container

- Base image
  - 1.20-alpine

### db container

- Base image
  - mysql/mysql-server:8.0
- architecture
  - Laravel 10.0
  - Vite 4.0
  - Vue 3.2
  - Vuex 4.0
  - Vue-router 4.1
  - Docker
  - nginx 1.2
  - MySQL 8.0
  - Bootstrap 5.2

### mailhog container

- Base image
  - mailhog/mailhog:latest

### minio container

- Base image
  - quay.io/minio/minio

## Authentication

Sanctum with Cookie.
