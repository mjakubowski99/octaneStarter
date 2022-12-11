#!/usr/bin/env bash

CONTAINER_FIRST_STARTUP="CONTAINER_FIRST_STARTUP"

if [ ! -e /$CONTAINER_FIRST_STARTUP ]; then
    touch /$CONTAINER_FIRST_STARTUP
    composer install
    npm install chokidar
    php artisan storage:link
    php artisan key:generate
    php artisan migrate
    php artisan config:clear
    php artisan route:clear
else
    composer install
    php artisan config:clear
    php artisan route:clear
fi

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.app.conf

