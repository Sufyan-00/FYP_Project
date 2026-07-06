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

cat > /etc/apache2/ports.conf <<EOF
Listen ${PORT}
EOF

cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:${PORT}>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

echo "=== Starting Apache on port ${PORT} ==="
exec apache2-foreground