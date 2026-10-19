#!/bin/bash
set -e

echo "=== FYP Proposal System Bootstrap ==="

cd /var/www/html

# 1. Cache Laravel config, routes, views
echo "Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Run migrations
echo "Running migrations..."
php artisan migrate --force

# 3. Auto-seed on first run (when users table is empty)
echo "Checking if seeding is needed..."
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | grep -E '^[0-9]+$' | tail -1)
if [ -z "$USER_COUNT" ] || [ "$USER_COUNT" = "0" ]; then
    echo "Database is empty — running seeders..."
    php artisan db:seed --force

    # Run specific class seeder
    echo "Running GuestModeSeeder..."
    php artisan db:seed --class=GuestModeSeeder --force
    
    echo "Seeding complete!"
else
    echo "Database already seeded (${USER_COUNT} users found) — skipping."
fi

# 4. Create storage symlink
echo "Creating storage link..."
php artisan storage:link || true

# ---------------------------------------------------------------
# If extra arguments were passed (e.g. from `heroku run`), execute
# them directly instead of starting the web server.
# ---------------------------------------------------------------
if [ "$#" -gt 0 ]; then
    echo "=== Running one-off command: $@ ==="
    exec "$@"
fi

# 5. Configure Nginx with dynamic Heroku PORT (web process only)
PORT=${PORT:-80}
echo "Configuring Nginx on port ${PORT}..."
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

# 6. Start PHP-FPM in background
echo "Starting PHP-FPM..."
php-fpm --daemonize

# 7. Start Nginx in foreground (keeps container running)
echo "=== Starting Nginx on port ${PORT} ==="
exec nginx -c /etc/nginx/nginx.conf