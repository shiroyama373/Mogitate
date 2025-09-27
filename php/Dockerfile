FROM php:8.3-fpm

# PHP拡張をインストール
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git \
    && docker-php-ext-install pdo_mysql zip

WORKDIR /var/www/html
