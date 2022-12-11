ARG PHP_VERSION=8.2

FROM php:${PHP_VERSION}

ENV USER=octane
ENV GROUP=octane

WORKDIR /var/www

RUN apt-get update
RUN apt-get install -y openssl curl ca-certificates zip unzip git supervisor pkg-config libonig-dev libxml2-dev libzip-dev libicu-dev
RUN docker-php-ext-install mbstring xml zip bcmath intl opcache pdo_mysql
RUN pecl install swoole xdebug
RUN docker-php-ext-enable swoole

RUN apt-get install -y nodejs npm

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN useradd -ms /bin/bash {$USER}

RUN groupmod -o -g 1000 www-data && usermod -o -u 1000 -g www-data www-data
USER {$USER}

COPY .docker/octane/docker-entrypoint.sh /opt/docker-entrypoint.sh
COPY .docker/octane/php.ini /usr/local/etc/php/conf.d/octane.ini
COPY .docker/octane/supervisord* /etc/supervisor/conf.d/

WORKDIR /var/www
ENTRYPOINT ["bash", "/opt/docker-entrypoint.sh"]

EXPOSE 9000

USER root
RUN chown -R {$USER}:{$USER} /var/www
RUN chmod -R ug+w /var/www

HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD php artisan octane:status || exit 1




