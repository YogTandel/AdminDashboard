FROM php:8.2-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    libzip-dev libcurl4-openssl-dev pkg-config libssl-dev libicu-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo mbstring zip exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

CMD ["php-fpm"]
