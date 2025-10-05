# PHP 8.1 FPM イメージを使用
FROM php:8.1-fpm

# システムのパッケージを更新・インストール
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql zip \
    && docker-php-ext-enable pdo_mysql

# 作業ディレクトリを /var/www に設定
WORKDIR /var/www

# Composer をインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer