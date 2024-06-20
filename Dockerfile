FROM composer AS builder
WORKDIR /home/app
COPY . .
RUN composer install --no-dev


FROM php:apache

ENV APACHE_DOCUMENT_ROOT /home/app/public
ENV APACHE_DOCUMENT_ROOT /home/app/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    curl \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /home/app
COPY --from=builder --chown=www-data:www-data  /home/app /home/app