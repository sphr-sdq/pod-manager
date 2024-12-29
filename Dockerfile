FROM php:8.2-fpm-alpine

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

WORKDIR /var/www

# Install Composer
COPY . .

# Install Laravel dependencies and generate app key
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN php artisan key:generate

# Install Node dependencies and build Vue/Inertia
RUN npm install && npm run build

# Set correct permissions (important for Alpine)
RUN chown -R www-data:www-data /var/www

USER www-data

EXPOSE 9000

CMD ["php-fpm"]