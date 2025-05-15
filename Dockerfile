FROM php:8.2-cli

WORKDIR /app

# Install git and unzip utilities only
RUN apt-get update && apt-get install -y git unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY composer.json composer.lock* ./

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

RUN composer install --no-dev --optimize-autoloader

COPY . .

EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
