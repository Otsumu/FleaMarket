FROM php:8.1-fpm

COPY php.ini /usr/local/etc/php/

RUN apt-get update \
  && apt-get -y install --no-install-recommends \
     git \
     unzip \
     libpq-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
  && docker-php-ext-install \
     pdo_mysql \
     gd

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

WORKDIR /var/www
