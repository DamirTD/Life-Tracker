# Use an official PHP image as the base (change to PHP 8.2)
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer globally
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set the working directory to /var/www
WORKDIR /var/www

# Copy the current project to the working directory in the container
COPY . .

# Install PHP dependencies
RUN composer install

# Give permissions to storage and bootstrap cache directories
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start the PHP-FPM server
CMD ["php-fpm"]
