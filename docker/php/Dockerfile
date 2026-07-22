FROM php:8.4-fpm-alpine

# Instalar dependencias
RUN apk add --no-cache \
    git \
    unzip \
    zip \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    nodejs \
    npm \
    bash \
    bash-completion

# Instalar extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) \
    gd \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    opcache

# ============================================
# CONFIGURAR ZONA HORARIA CDMX
# ============================================
# Establecer timezone en el sistema
RUN apk add --no-cache tzdata && \
    cp /usr/share/zoneinfo/America/Mexico_City /etc/localtime && \
    echo "America/Mexico_City" > /etc/timezone && \
    apk del tzdata

# Configurar timezone en PHP
RUN echo "date.timezone=America/Mexico_City" > /usr/local/etc/php/conf.d/timezone.ini

# ============================================
# INSTALAR COMPOSER
# ============================================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ============================================
# CONFIGURACIÓN DE PHP
# ============================================
RUN echo "memory_limit=256M" > /usr/local/etc/php/conf.d/memory.ini && \
    echo "upload_max_filesize=100M" > /usr/local/etc/php/conf.d/upload.ini && \
    echo "post_max_size=100M" > /usr/local/etc/php/conf.d/post.ini && \
    echo "max_execution_time=300" > /usr/local/etc/php/conf.d/timeout.ini

WORKDIR /var/www/html

# Instalar Laravel Octane (opcional)
# RUN composer require laravel/octane

# Exponer puerto
EXPOSE 9000

# Comando por defecto
CMD ["php-fpm"]