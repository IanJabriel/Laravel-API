FROM composer AS builder
WORKDIR /home/app
COPY . .
RUN composer install


FROM php:apache

ENV APACHE_DOCUMENT_ROOT /home/app/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /home/app
COPY --from=builder --chown=www-data:www-data  /home/app /home/app