FROM php:8.2.12-apache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && docker-php-ext-install pdo_mysql
    
RUN sed -i 's!/var/www/html!/var/www/app/public!g' /etc/apache2/sites-available/000-default.conf
