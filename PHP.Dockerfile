FROM php:7.1.3-fpm

RUN apt-get update \
    && apt-get install -y 