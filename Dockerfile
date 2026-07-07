FROM php:8.2-fpm

# 1. Install system dependencies (nginx, gettext for envsubst)
RUN apt-get update && apt-get install -y \
    nginx \
    gettext-base \
    libpq-dev \
    libzip-dev \
    zip unzip git curl \
    && docker-php-ext-install pdo_pgsql pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# 2. Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# 3. Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 4. Copy application files
COPY . /var/www/html
WORKDIR /var/www/html

# 5. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 6. Build Vite/Tailwind assets
RUN npm install && npm run build

# 7. Set folder permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Copy Nginx config template
COPY nginx.conf.template /etc/nginx/nginx.conf.template

# 9. Setup Entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]