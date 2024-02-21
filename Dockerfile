# Use the official PHP image with Apache
FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN echo '<Directory "/var/www/html/public">\n\tAllowOverride All\n</Directory>' > /etc/apache2/conf-available/laravel.conf && a2enconf laravel

RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Comment out or remove the next line to avoid copying .env.example to .env
# COPY .env.example .env

# Set Apache document root to the public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Use sed to replace the default document root in the Apache configuration
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Run Composer Install
RUN composer install --no-dev
RUN composer dump-autoload -o
RUN php artisan config:cache
RUN php artisan route:cache

# Generate key
RUN php artisan key:generate

# Link public repo
RUN rm -f public/storage
RUN php artisan storage:link

# Change ownership of our applications
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 storage bootstrap/cache

# Expose port 80
EXPOSE 80