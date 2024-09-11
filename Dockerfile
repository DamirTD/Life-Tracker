FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

RUN composer install

WORKDIR /var/www/html

RUN chmod -R 775 /var/www/html/storage

EXPOSE 80
