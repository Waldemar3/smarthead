#!/bin/bash
set -e

cd /var/www/html

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --no-interaction --force 2>/dev/null || true

php artisan migrate --force --no-interaction 2>/dev/null || true

php artisan db:seed --force --no-interaction 2>/dev/null || true

php artisan storage:link --force 2>/dev/null || true

exec "$@"
