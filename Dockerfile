# Use an official PHP image with Apache
FROM php:8.2-apache

# 1. Install system dependencies + Node.js 20
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip unzip git curl \
    && docker-php-ext-install pdo_pgsql pdo_mysql zip

# Install Node.js 20 (needed to build Vite/Tailwind assets)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 2. Tell Apache to look at Laravel's /public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite

# 3. Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 4. Copy application files
COPY . /var/www/html
WORKDIR /var/www/html

# 5. Install PHP dependencies (no dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 6. Install Node dependencies and build Vite assets
RUN npm ci && npm run build

# 7. Set folder permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Expose port (Heroku dynamically overrides via $PORT at runtime)
EXPOSE 80

# 9. Setup Entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]