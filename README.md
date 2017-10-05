# kabouterwesley.be

Source code of [kabouterwesley.be](https://kabouterwesley.be), formerly [ikhaat.be](https://ikhaat.be)

## Setup

Add an entry to your `/etc/hosts` file:

```shell
127.0.0.1 kabouterwesley.dev
```

### Environment variables

Copy the `.env.example` file and adjust the hostname to `kabouterwesley.dev`

```shell
cp .env.example .env
```

### Dependencies

Install Composer dependencies:

```shell
composer install
```

Install NodeJS dependencies:

```shell
npm install
npm install -g gulp
```

### Compiling frontend app

Compile the frontend app using Gulp:

```shell
gulp
```

To keep watching files for changes, use:

```shell
gulp watch
```

### Docker

Included Docker services:

- **nginx**
- **php**

Just start Docker like this (add the `-d` flag to run in background):

```shell
docker-compose -f docker/docker-compose-dev.yml up
```
