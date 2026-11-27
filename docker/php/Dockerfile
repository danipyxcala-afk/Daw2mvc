# PHP-FPM con la extensión mysqli (la que usa config/DataBase.php).
# mbstring (mb_strlen) ya viene incluida en la imagen oficial.
# Se construye desde la raíz del proyecto (context: .) para poder copiar el código.
FROM php:8.5-fpm

RUN docker-php-ext-install mysqli

COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-daw2mvc.ini

WORKDIR /var/www/html

# El código va dentro de la imagen (Portainer). En local docker-compose.yml lo tapa con un volumen.
COPY . /var/www/html
