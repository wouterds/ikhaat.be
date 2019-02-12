FROM nginx:1.15-alpine
LABEL maintainer="Wouter De Schuyter <wouter.de.schuyter@gmail.com>"

# Copy config files
COPY ./.docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy project
COPY ./public /code/public
