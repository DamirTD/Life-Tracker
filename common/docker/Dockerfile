
FROM php:8.3-fpm AS base

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    zip \
    unzip \
    git \
    nginx \
    && docker-php-ext-install pdo_mysql gd \
    && apt-get clean

# Копируем composer в контейнер
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируем конфигурацию Nginx
COPY ./nginx/default.conf /etc/nginx/nginx.conf


