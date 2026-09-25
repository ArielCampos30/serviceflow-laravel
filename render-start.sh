#!/bin/sh
set -eu

DB_FILE="${DB_DATABASE:-/tmp/serviceflow.sqlite}"
mkdir -p "$(dirname "$DB_FILE")"
touch "$DB_FILE"

php artisan config:cache
php artisan migrate --force
php artisan db:seed --force

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
