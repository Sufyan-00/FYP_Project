# Use an official PHP image with Apache
FROM php:8.2-apache

# 1. Install system dependencies
# FIX: Changed 'libzip-dir' to 'libzip-dev' so the build doesn't fail
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip unzip git \
    && docker-php-ext-install pdo_pgsql pdo_mysql zip

# 2. Tell Apache to look at Laravel's /public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite

# 3. Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 4. Copy application files
COPY . /var/www/html
WORKDIR /var/www/html

# 5. Install dependencies
# Using --ignore-platform-reqs is sometimes safer in Docker if local php version differs
RUN composer install --no-dev --optimize-autoloader

# 6. Set folder permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 7. Expose port 80
EXPOSE 80

# 8. Setup Entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]