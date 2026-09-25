#!/bin/sh
set -eu

export APP_ENV="${APP_ENV:-production}"
export APP_DEBUG="${APP_DEBUG:-false}"
export APP_TIMEZONE="${APP_TIMEZONE:-America/Argentina/Cordoba}"
export APP_LOCALE="${APP_LOCALE:-es}"
export APP_FALLBACK_LOCALE="${APP_FALLBACK_LOCALE:-es}"
export LOG_CHANNEL="${LOG_CHANNEL:-stderr}"
export LOG_LEVEL="${LOG_LEVEL:-info}"
export DB_CONNECTION="${DB_CONNECTION:-sqlite}"
export DB_DATABASE="${DB_DATABASE:-/tmp/serviceflow.sqlite}"
export SESSION_DRIVER="${SESSION_DRIVER:-file}"
export CACHE_STORE="${CACHE_STORE:-file}"
export QUEUE_CONNECTION="${QUEUE_CONNECTION:-sync}"
export DEMO_ADMIN_PASSWORD="${DEMO_ADMIN_PASSWORD:-ServiceFlowDemo!26}"
export SERVICEFLOW_API_TOKEN="${SERVICEFLOW_API_TOKEN:-$(php -r 'echo bin2hex(random_bytes(24));')}"

if [ -z "${APP_KEY:-}" ]; then
  export APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
fi

mkdir -p "$(dirname "$DB_DATABASE")"
touch "$DB_DATABASE"

php artisan config:cache
php artisan migrate --force
php artisan db:seed --force

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
