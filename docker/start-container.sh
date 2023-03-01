#!/usr/bin/env bash

set -e

env=${APP_ENV:-production}

cd /app

chmod 777 storage -R
chmod 777 bootstrap/cache -R

if [ "$env" != "local" ]; then
    echo "Caching configuration..."
    (
        php artisan view:cache &&
            php artisan route:cache &&
            php artisan config:cache
    )
fi

php artisan migrate --force
chmod 777 storage/database.sqlite

exec apache2-foreground
