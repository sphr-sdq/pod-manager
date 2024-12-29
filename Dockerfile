FROM php:8.2-fpm-alpine AS builder

# Install necessary packages (Alpine)
RUN apk add --no-cache \
    build-base \
    libpng-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    postgresql-dev # PostgreSQL client for Alpine

# Install PHP extensions (Alpine uses apk and different package names)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project
COPY . .

FROM builder

# Copy php.ini
COPY /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini


# Install Laravel dependencies and generate app key
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN php artisan key:generate --show | tee /tmp/app_key && export APP_KEY=$(cat /tmp/app_key)

# Install Node dependencies and build Vue/Inertia
RUN npm install && npm run build

# Change ownership
RUN chown -R www-data:www-data /var/www

# Switch to www-data user
USER www-data

# Expose port
EXPOSE 9000

# Command
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "9000"]