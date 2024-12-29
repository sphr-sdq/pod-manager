# Use official PHP image with Apache and FPM
FROM php:8.2-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk --no-cache add \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libfreetype6-dev \
    libpq-dev \
    bash \
    git \
    curl \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql \
    && apk del bash

# Install Composer (PHP package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js (for Vue/Vite)
RUN apk add --no-cache nodejs npm

# Set working directory
WORKDIR /var/www/html

# Copy the Laravel app into the container
COPY . .

# Install PHP dependencies (composer install)
RUN composer install --no-dev --optimize-autoloader

# Install Node.js dependencies and build the Vue.js app
RUN npm install
RUN npm run build

# Set up permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose the port that Apache will run on
EXPOSE 80

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy Apache configuration file (optional, if needed)
COPY ./apache2.conf /etc/apache2/

# Start Apache in the foreground
CMD ["apache2-foreground"]
