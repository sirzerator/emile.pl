FROM node:latest AS node
FROM php:8.2

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update -yqq && \
	apt-get install libjpeg-dev libpng-dev libxpm-dev libzip-dev unzip -yqq

RUN docker-php-ext-install gd zip pcntl bcmath mysqli pdo_mysql sockets gettext

RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

COPY package.json /usr/src/app
RUN npm install

COPY . /usr/src/app
