FROM php:8.0-fpm-alpine

# Install packages
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    libpq-dev \
    build-base \
    zlib-dev \
    oniguruma-dev \
    autoconf \
    bash \
    linux-headers

RUN pecl install xdebug && docker-php-ext-enable xdebug;

COPY ./docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Install PHP extensions
RUN docker-php-ext-install \
        pdo_pgsql \
        opcache \
        bcmath

# Configure non-root user.
ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Source code
RUN chown www-data:www-data /var/www
COPY --chown=www-data:www-data ./ /var/www
WORKDIR /var/www

USER www-data

## Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#RUN composer install --no-interaction

EXPOSE 9000

CMD ["php-fpm"]