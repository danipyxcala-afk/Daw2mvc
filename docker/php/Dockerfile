# PHP-FPM con la extensión mysqli (la que usa config/DataBase.php).
# mbstring (mb_strlen) ya viene incluida en la imagen oficial.
FROM php:8.5-fpm

RUN docker-php-ext-install mysqli

COPY php.ini /usr/local/etc/php/conf.d/zz-daw2mvc.ini

WORKDIR /var/www/html
