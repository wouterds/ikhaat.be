FROM nginx:1.13-alpine
MAINTAINER Wouter De Schuyter <wouter.de.schuyter@gmail.com>

# Nginx configuration file
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy project
COPY ./ /code
