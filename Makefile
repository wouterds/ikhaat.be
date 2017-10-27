all: tag

VERSION = $(shell cat package.json | grep "version" | sed -e 's/^.*: "\(.*\)".*/\1/')
PWD = $(shell pwd)

DOCKER_REPO  = docker.wouterdeschuyter.be
PROJECT_NAME = internal-kabouterwesley-website

TAG_NGINX = $(DOCKER_REPO)/$(PROJECT_NAME)-nginx
TAG_PHP_FPM = $(DOCKER_REPO)/$(PROJECT_NAME)-php-fpm

DOCKERFILE_NGINX = ./docker/nginx/Dockerfile
DOCKERFILE_PHP_FPM = ./docker/php-fpm/Dockerfile

clean:
	-rm -rf ./.version
	-rm -rf ./node_modules
	-rm -rf ./vendor
	-rm -rf ./public/static
	-rm -f ./.build-*
	-rm -f ./composer.phar

composer.phar:
	docker run --rm --volume=$(PWD):/code -w=/code php:7.1-alpine php -r 'copy("https://getcomposer.org/installer", "./composer-setup.php");'
	docker run --rm --volume=$(PWD):/code -w=/code php:7.1-alpine php ./composer-setup.php
	docker run --rm --volume=$(PWD):/code -w=/code php:7.1-alpine php -r 'unlink("./composer-setup.php");'

vendor: composer.phar composer.json composer.lock
	docker run --rm --volume=$(PWD):/code -w=/code php:7.1-alpine php ./composer.phar install --ignore-platform-reqs --prefer-dist --no-progress --optimize-autoloader

node_modules: package.json
	docker run --rm --volume=$(PWD):/code -w=/code node:8-slim npm install

dependencies: vendor node_modules

.build-app: dependencies
	docker run --rm --volume=$(PWD):/code -w=/code node:8-slim ./node_modules/.bin/gulp
	touch .build-app

.build-nginx: $(DOCKERFILE_NGINX)
	docker build $(BUILD_NO_CACHE) -f $(DOCKERFILE_NGINX) -t $(TAG_NGINX) .
	touch .build-nginx

.build-php-fpm: $(DOCKERFILE_PHP_FPM)
	docker build $(BUILD_NO_CACHE) -f $(DOCKERFILE_PHP_FPM) -t $(TAG_PHP_FPM) .
	touch .build-php-fpm

build: .build-app .build-nginx .build-php-fpm

tag: build
	docker tag $(TAG_NGINX) $(TAG_NGINX):$(VERSION)
	docker tag $(TAG_PHP_FPM) $(TAG_PHP_FPM):$(VERSION)

push: tag
	docker push $(TAG_NGINX):$(VERSION)
	docker push $(TAG_PHP_FPM):$(VERSION)

push-latest: push
	docker push $(TAG_NGINX):latest
	docker push $(TAG_PHP_FPM):latest
