FROM php:8.2-cli

WORKDIR /app

# Install git and unzip utilities only
RUN apt-get update && apt-get install -y git unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy composer files first
COPY composer.json composer.lock* ./

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Install dependencies and generate optimized autoloader
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy the rest of the application
COPY . .

# Generate optimized autoloader again after copying all files
RUN composer dump-autoload --optimize --no-dev

EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
