# Base image with PHP and extensions
FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Install common PHP extensions (e.g., curl, mbstring, etc.)
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    zip \
    libzip-dev \
    && docker-php-ext-install zip

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy your application code
COPY . .

# Install PHP dependencies (if using Composer)
RUN composer install

# Expose port (matches docker-compose)
EXPOSE 10000

# Default command (overridden in compose)
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
