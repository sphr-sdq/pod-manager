FROM php:8.2-fpm

 # Copy a simple PHP file
 COPY test.php /var/www/html/test.php
COPY www.conf /usr/local/etc/php-fpm.d/www.conf


 # Expose port
 EXPOSE 9000

 CMD ["php-fpm"]