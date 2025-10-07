FROM php:8.3-fpm

# システムパッケージと PHP 拡張
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git default-mysql-client \
    && docker-php-ext-install pdo_mysql zip

WORKDIR /var/www/html