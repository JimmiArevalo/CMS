# --------------------------------------------------------------
# Dockerfile – Laravel en Render
# --------------------------------------------------------------
# Base image (Ubuntu + PHP 8.2 + extensions)
FROM php:8.2-fpm

# ---------- System dependencies ----------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql zip bcmath gd

# ---------- Composer ----------
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# ---------- Workdir ----------
WORKDIR /app

# ---------- PHP configuration ----------
RUN echo "opcache.enable=1\nopcache.memory_consumption=128\nopcache.max_accelerated_files=4000\nopcache.validate_timestamps=0" > /usr/local/etc/php/conf.d/opcache-recommended.ini

# ---------- Install PHP dependencies ----------
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# ---------- Install Node dependencies ----------
COPY package.json package-lock.json ./
RUN apt-get install -y npm && npm ci && npm run build

# ---------- Copy source code ----------
COPY . .

# ---------- Permissions ----------
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# ---------- Expose the port that Render will set ----------
EXPOSE 10000

# ---------- Entrypoint ----------
# Render injecta la variable $PORT; usamos php-fpm + Caddy para servir HTTP.
# Caddy está incluido en la imagen oficial de Render para Laravel, pero
# si prefieres usar el servidor interno de Laravel (solo para pruebas):
CMD php artisan serve --host=0.0.0.0 --port=$PORT
