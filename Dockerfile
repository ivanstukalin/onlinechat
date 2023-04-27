FROM php:8-fpm

RUN apt-get update && apt-get install -y curl git zip sudo \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Открываем порт для PostgreSQL
EXPOSE 5432

