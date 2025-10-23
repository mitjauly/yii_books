FROM php:8.1-fpm-alpine

# Install essential system dependencies
RUN apk add --no-cache \
    git \
    curl \
    sudo \
    mc \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    libzip-dev \
    zip \
    unzip

# Install PHP extensions required by Yii2
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        gd \
        intl \
        zip \
        opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Allow Composer to run as superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

# Configure PHP settings for Yii2
RUN echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/yii.ini \
    && echo "upload_max_filesize = 64M" >> /usr/local/etc/php/conf.d/yii.ini \
    && echo "post_max_size = 64M" >> /usr/local/etc/php/conf.d/yii.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/yii.ini

# Set working directory
WORKDIR /app

# Expose port 9000 for PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
