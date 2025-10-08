FROM php:8.2-fpm
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev libpng-dev \
 && docker-php-ext-install pdo pdo_mysql intl zip gd
WORKDIR /var/www/html
