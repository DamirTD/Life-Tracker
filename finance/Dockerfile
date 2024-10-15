FROM php:8.2-fpm AS finance

RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    supervisor \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/finance

COPY . .

RUN rm -rf vendor

RUN composer install --prefer-dist --no-dev --optimize-autoloader

