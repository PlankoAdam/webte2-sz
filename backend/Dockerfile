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




# # Install required PHP extensions
# RUN docker-php-ext-install pdo pdo_mysql

# # Install system dependencies
# RUN apt-get update && apt-get install -y \
#     git \
#     zip \
#     unzip

# # Install Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Set working directory
# WORKDIR /var/www/php

# # Copy composer.json and composer.lock to install dependencies
# COPY composer.json composer.lock ./

# # Install project dependencies
# RUN composer install --no-dev --optimize-autoloader

# # Copy the rest of your application files
# COPY . .


