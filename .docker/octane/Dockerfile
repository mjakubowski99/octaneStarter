ARG PHP_VERSION=8.2

FROM php:${PHP_VERSION}-alpine

ENV USER=octane
ENV GROUP=octane

WORKDIR /var/www

RUN apt update
RUN apt install -y  \
    supervisor \
    php${PHP_VERSION}-curl php${PHP_VERSION}-openssl  \
    php${PHP_VERSION}-mbstring php${PHP_VERSION}-xml  \
    php${PHP_VERSION}-zip php${PHP_VERSION}-bcmath  \
    php${PHP_VERSION}-intl php${PHP_VERSION}-opcache \
    php${PHP_VERSION}-swoole php${PHP_VERSION}-xdebug  \
    php${PHP_VERSION}-mysql

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

COPY .docker/octane/docker-entrypoint.sh /opt/docker-entrypoint.sh
COPY .docker/octane/php.ini /usr/local/etc/php/conf.d/octane.ini

RUN groupadd -g 1000 {$GROUP}
RUN useradd -u 1000 -ms /bin/bash -g {$GROUP} {$USER}

COPY --chown={$GROUP}:{$USER} . /var/www

RUN mkdir -p storage/framework/{sessions,views,cache}
RUN mkdir -p storage/logs
RUN mkdir -p bootstrap/cache

RUN chown -R www:www storage bootstrap/cache
RUN chmod -R ug+rwx storage bootstrap/cache

USER {$USER}

EXPOSE 9000

ENTRYPOINT ["bash", "/opt/docker-entrypoint.sh"]

HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD php artisan octane:status || exit 1




