FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

WORKDIR /var/www

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application code
COPY . /var/www

# Install Node dependencies and build Vue/Inertia
RUN npm install && npm run build

# Set correct permissions
RUN chown -R www-data:www-data /var/www

USER www-data

# Expose port 9000 for PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]