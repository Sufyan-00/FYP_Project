#!/bin/bash

# Exit immediately if a command exits with a non-zero status
set -e

# 1. Cache the configuration for speed
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Run database migrations (Force is needed in production)
echo "Running migrations..."
php artisan migrate --force

echo "Creating storage link..."
php artisan storage:link
# 3. Start Apache (this passes control back to the Docker command)
echo "Starting Apache..."
exec docker-php-entrypoint apache2-foreground