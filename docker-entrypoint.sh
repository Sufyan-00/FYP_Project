#!/bin/bash

# Exit immediately if a command exits with a non-zero status
set -e

echo "=== Starting FYP Proposal System ==="

# 1. Cache configuration for speed
echo "Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Run database migrations
echo "Running migrations..."
php artisan migrate --force

# 3. Create storage symlink
echo "Creating storage link..."
php artisan storage:link || true

# 4. Configure Apache to listen on Heroku's dynamic PORT
PORT=${PORT:-80}
echo "Configuring Apache on port ${PORT}..."

# Update ports.conf to listen on the correct port
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf

# Update the VirtualHost to bind to the correct port
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

echo "=== Starting Apache on port ${PORT} ==="
exec apache2-foreground