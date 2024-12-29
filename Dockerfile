FROM php:8.2-fpm-alpine

# Copy a simple PHP file
COPY test.php /var/www/html/test.php

# Expose port
EXPOSE 9000

CMD ["php-fpm"]