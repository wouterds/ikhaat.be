all: tag

VERSION = $(shell cat package.json | grep "version" | sed -e 's/^.*: "\(.*\)".*/\1/')
PWD = $(shell pwd)

DOCKER_REPO  = docker.wouterdeschuyter.be
PROJECT_NAME = internal-ikhaat-website

TAG_NGINX = $(DOCKER_REPO)/$(PROJECT_NAME)-nginx
TAG_PHP_FPM = $(DOCKER_REPO)/$(PROJECT_NAME)-php-fpm

DOCKERFILE_NGINX = ./docker/nginx/Dockerfile
DOCKERFILE_PHP_FPM = ./docker/php-fpm/Dockerfile

clean:
	-rm -f .build-*

.build-nginx: $(DOCKERFILE_NGINX)
	docker build $(BUILD_NO_CACHE) -f $(DOCKERFILE_NGINX) -t $(TAG_NGINX) .
	touch .build-nginx

.build-phpfpm: $(DOCKERFILE_PHP_FPM)
	docker build $(BUILD_NO_CACHE) -f $(DOCKERFILE_PHP_FPM) -t $(TAG_PHP_FPM) .
	touch .build-phpfpm

build: .build-nginx .build-phpfpm

tag: build
	docker tag $(TAG_NGINX) $(TAG_NGINX):$(VERSION)
	docker tag $(TAG_PHP_FPM) $(TAG_PHP_FPM):$(VERSION)

push: tag
	docker push $(TAG_NGINX):$(VERSION)
	docker push $(TAG_PHP_FPM):$(VERSION)

push-latest: push
	docker push $(TAG_NGINX):latest
	docker push $(TAG_PHP_FPM):latest
