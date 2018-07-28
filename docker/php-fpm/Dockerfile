FROM arm32v6/php:7.2-fpm-alpine
MAINTAINER Wouter De Schuyter <wouter.de.schuyter@gmail.com>

# Install GD extension
RUN apk add --no-cache \
      freetype-dev libpng-dev libjpeg-turbo-dev \
      freetype libpng libjpeg \
    && docker-php-ext-configure gd \
      --with-freetype-dir=/usr/include/ \
      --with-png-dir=/usr/include/ \
      --with-jpeg-dir=/usr/include/ \
    && NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
    && docker-php-ext-install -j${NPROC} gd \
    && apk del freetype-dev libpng-dev libjpeg-turbo-dev

# Copy project
COPY ./public/index.php /code/public/index.php
COPY ./src /code/src
COPY ./resources /code/resources
COPY ./vendor /code/vendor
