FROM php:7.1.9-fpm-alpine
COPY . /var/www/html/mvc_docroot/
RUN set -x &&\
  apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev && \
  docker-php-ext-configure gd \
    --with-gd \
    --with-freetype-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ && \
  docker-php-ext-install pdo_mysql mbstring gd exif
