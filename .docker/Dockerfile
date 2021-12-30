FROM php:5.6-fpm-alpine

MAINTAINER mgpapelaria.com.br

RUN apk add bash-completion
RUN apk upgrade --update
RUN apk add coreutils
RUN apk add postgresql-dev
RUN apk add libpng-dev
RUN apk add libxml2-dev
RUN docker-php-ext-install pgsql
RUN docker-php-ext-install gd
RUN docker-php-ext-install soap
RUN apk add curl-dev
RUN docker-php-ext-install curl
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install xml
RUN docker-php-ext-install pdo pdo_pgsql
