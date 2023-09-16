FROM php:8.2-apache

RUN apt-get update && apt-get install -y libpq-dev libonig-dev

RUN pecl install mongodb
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable mongodb opcache

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/apache/apache2.conf /etc/apache2/apache2.conf

RUN service apache2 reload # 必要?
