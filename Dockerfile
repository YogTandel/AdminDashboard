# Use official PHP 8.2 image with FPM
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application files
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm install && npm run build

# Set permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port 9000 and start PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
