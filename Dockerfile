# Use PHP 8.4 CLI (Alpine for smaller size)
FROM php:8.4-cli-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    netcat-openbsd

# Install PHP extensions
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath

# Update package lists and install nodejs and npm
RUN apk update && apk add --no-cache nodejs npm

# Verify the installation
RUN node -v
RUN npm -v

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies (including dev for development environment)
RUN composer install --optimize-autoloader --no-interaction

RUN npm install
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port 8000
EXPOSE 8000

# Set entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]

# Default command
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
