#!/bin/sh
set -e

echo "==> Building and starting containers..."
docker compose up -d --build

echo "==> Installing PHP dependencies (into Docker volume, not Windows mount)..."
docker compose exec app composer install --no-interaction --optimize-autoloader

echo "==> Configuring environment..."
docker compose exec app sh -c "test -f .env || cp .env.example .env"
docker compose exec app php artisan key:generate --force

echo "==> Publishing Filament assets..."
docker compose exec app php artisan filament:assets

echo "==> Running migrations..."
docker compose exec app php artisan migrate --force

echo "==> Caching config, routes and views..."
docker compose exec app php artisan optimize

echo ""
echo "Done! Open http://localhost:8080"
echo "Admin panel: http://localhost:8080/admin"
