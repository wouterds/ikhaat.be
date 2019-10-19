PWD = $(shell pwd)
VERSION = $(shell cat composer.json | grep "\"version\"" | sed -e 's/^.*: "\(.*\)".*/\1/')

DOCKER_COMPOSE = ./.docker/docker-compose.yml
DOCKERFILE_PHP_FPM = ./.docker/php-fpm/Dockerfile
DOCKERFILE_NGINX = ./.docker/nginx/Dockerfile

TAG_PREFIX = docker.pkg.github.com/wouterds/ikhaat.be
TAG_PHP_FPM = ${TAG_PREFIX}/php-fpm
TAG_NGINX = ${TAG_PREFIX}/nginx

all: build

clean:
	-rm -rf ./.version
	-rm -rf ./node_modules
	-rm -rf ./vendor
	-rm -rf ./public/static
	-rm -f ./.build-*
	-rm -f ./composer.phar
	-rm -f ./qemu-arm-static

composer.phar:
	docker run --rm --volume=${PWD}:/code -w=/code php:7.3-alpine php -r 'copy("https://getcomposer.org/installer", "./composer-setup.php");'
	docker run --rm --volume=${PWD}:/code -w=/code php:7.3-alpine php ./composer-setup.php
	docker run --rm --volume=${PWD}:/code -w=/code php:7.3-alpine php -r 'unlink("./composer-setup.php");'

vendor: composer.phar composer.json composer.lock
	docker run --rm --volume=${PWD}:/code -w=/code php:7.3-alpine php ./composer.phar install --ignore-platform-reqs --prefer-dist --no-progress --optimize-autoloader

node_modules: package.json
	docker run --rm --volume=${PWD}:/code -w=/code node:12-slim npm install

dependencies: vendor node_modules

qemu-arm-static:
	docker run --rm --privileged multiarch/qemu-user-static:register --reset
	curl -OL https://github.com/multiarch/qemu-user-static/releases/download/v4.1.0-1/qemu-arm-static
	chmod +x qemu-arm-static

.build-app: dependencies
	docker run --rm --volume=${PWD}:/code -w=/code node:12-slim npm run build
	touch .build-app

.build-nginx: ${DOCKERFILE_NGINX}
	docker build -f ${DOCKERFILE_NGINX} -t ${TAG_NGINX} .
	touch .build-nginx

.build-php-fpm: qemu-arm-static .build-app ${DOCKERFILE_PHP_FPM}
	docker build --build-arg URL=${URL} -f ${DOCKERFILE_PHP_FPM} -t ${TAG_PHP_FPM} .
	touch .build-php-fpm

build: .build-php-fpm .build-nginx
	docker tag ${TAG_PHP_FPM} ${TAG_PHP_FPM}:${VERSION}
	docker tag ${TAG_NGINX} ${TAG_NGINX}:${VERSION}

docker-login:
	docker login docker.pkg.github.com -u wouterds -p ${GITHUB_TOKEN}

push: docker-login build
	docker push ${TAG_PHP_FPM}
	docker push ${TAG_PHP_FPM}:${VERSION}
	docker push ${TAG_NGINX}
	docker push ${TAG_NGINX}:${VERSION}

deploy:
	ssh ${DEPLOY_USER}@${DEPLOY_HOST} "mkdir -p ${DEPLOY_PATH}"
	scp ${DOCKER_COMPOSE} ${DEPLOY_USER}@${DEPLOY_HOST}:${DEPLOY_PATH}/docker-compose.yml
	ssh ${DEPLOY_USER}@${DEPLOY_HOST} "cd ${DEPLOY_PATH}; docker-compose pull"
	ssh ${DEPLOY_USER}@${DEPLOY_HOST} "cd ${DEPLOY_PATH}; docker-compose up -d"
