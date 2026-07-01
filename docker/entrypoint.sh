#!/bin/sh
set -e

# Ensure writable dirs exist (named volumes may be empty on first run)
mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

exec docker-php-entrypoint "$@"
