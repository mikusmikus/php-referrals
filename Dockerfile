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

# Copy the entire application
COPY . .

# Install dependencies and generate optimized autoloader
RUN composer install --no-dev --optimize-autoloader && \
    composer dump-autoload -o && \
    ls -la /app/src/Services/ && \
    cat /app/src/Services/ReferralService.php

EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
