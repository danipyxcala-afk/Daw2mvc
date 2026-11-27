# nginx con la config del proyecto y los archivos estáticos dentro de la imagen.
# Necesita también los .php porque comprueba que existan antes de pasarlos a PHP-FPM.
FROM nginx:1.27-alpine

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY . /var/www/html
