FROM arm32v6/php:7.3-fpm-alpine
LABEL maintainer="Wouter De Schuyter <wouter.de.schuyter@gmail.com>"

# Add qemu bin
COPY ./qemu-arm-static /usr/bin/qemu-arm-static

# Install extensions
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

# Remove qemu bin
RUN rm /usr/bin/qemu-arm-static

# Copy project
COPY ./public/index.php /code/public/index.php
COPY ./src /code/src
COPY ./resources /code/resources
COPY ./vendor /code/vendor

ARG URL
ENV URL=${URL}

WORKDIR /code
