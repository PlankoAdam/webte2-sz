FROM php:8.1-fpm

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/php

COPY composer.json composer.json

COPY composer.lock composer.lock

RUN composer install

COPY . .

RUN composer dump-autoload


