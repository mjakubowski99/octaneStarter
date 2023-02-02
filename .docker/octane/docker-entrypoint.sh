#!/usr/bin/env bash

CONTAINER_FIRST_STARTUP="CONTAINER_FIRST_STARTUP"

function fix_permissions() {
    chmod -R 777 bootstrap/cache
    chmod -R 666 storage/logs
    chmod -R 777 storage/app/public
}

function clear_cache() {
    rm -Rf bootstrap/cache/*.php
    rm -Rf storage/framework/cache/data/*.php
    php artisan optimize:clear
    php artisan view:cache
    php artisan clear-compiled
}

if [ ! -e /$CONTAINER_FIRST_STARTUP ]; then
    touch /$CONTAINER_FIRST_STARTUP
    composer install
    npm install chokidar
    php artisan storage:link
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    clear_cache
else
    composer install
    clear_cache
    php artisan migrate
fi

fix_permissions

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.app.conf

