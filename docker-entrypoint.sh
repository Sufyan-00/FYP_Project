#!/bin/bash
set -e

echo "=== Starting FYP Proposal System (Nginx + PHP-FPM) ==="

cd /var/www/html

# 1. Cache Laravel config, routes, views
echo "Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Run migrations
echo "Running migrations..."
php artisan migrate --force

# 3. Create storage symlink
echo "Creating storage link..."
php artisan storage:link || true

# 4. Configure Nginx with dynamic Heroku PORT
PORT=${PORT:-80}
echo "Configuring Nginx on port ${PORT}..."
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

# 5. Start PHP-FPM in background
echo "Starting PHP-FPM..."
php-fpm --daemonize

# 6. Start Nginx in foreground (keeps container running)
echo "=== Starting Nginx on port ${PORT} ==="
exec nginx -c /etc/nginx/nginx.conf