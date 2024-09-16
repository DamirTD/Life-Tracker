FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN composer install

WORKDIR /var/www/html

RUN chmod -R 775 /var/www/html/storage

COPY ./apache-config.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
