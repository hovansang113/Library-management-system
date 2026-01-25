# Base image PHP 8.4 CLI
FROM php:8.4-cli

# Cài system packages + PHP extensions cần thiết
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Cài Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy source code
COPY . .

# Cài dependency PHP
RUN if [ -f composer.json ]; then composer install; fi

# Expose port
EXPOSE 8000

# Run PHP built-in server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
