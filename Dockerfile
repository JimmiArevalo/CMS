# --------------------------------------------------------------
# Dockerfile – Laravel en Render (multi‑stage)
# --------------------------------------------------------------

# ---------- 1️⃣ Build stage (Node) ----------
FROM node:20-alpine AS node
WORKDIR /app

# Copiamos solo los archivos de dependencias para aprovechar la caché
COPY package*.json ./
RUN npm ci && npm run build

# ---------- 2️⃣ Build stage (PHP) ----------
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
    && docker-php-ext-install pdo_mysql zip bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# ---------- Composer ----------
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# ---------- Workdir ----------
WORKDIR /app

# ---------- PHP configuration ----------
RUN echo "opcache.enable=1\nopcache.memory_consumption=128\nopcache.max_accelerated_files=4000\nopcache.validate_timestamps=0" \
    > /usr/local/etc/php/conf.d/opcache-recommended.ini

# ---------- Install PHP dependencies ----------
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# ---------- Copy compiled assets from node stage ----------
COPY --from=node /app/public ./public

# ---------- Copy source code ----------
COPY . .

# ---------- Permissions ----------
RUN chown -R www-data:www-data storage bootstrap/cache

# ---------- Expose port (Render asigna $PORT) ----------
EXPOSE 10000

# ---------- Entrypoint ----------
CMD ["php-fpm"]