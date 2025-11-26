# -------- Stage 1: Build Vite assets (Node) --------
FROM node:18 AS node_builder

WORKDIR /app

# package.json をコピーして依存関係インストール
COPY package*.json ./
RUN npm install

# プロジェクト全体をコピー
COPY . .

# Vite の本番ビルド
RUN npm run build



# -------- Stage 2: PHP (FPM) --------
FROM php:8.3-fpm AS php_runtime

# 必要な拡張をインストール
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    libpng-dev \
    supervisor \
    nginx \
    && docker-php-ext-install pdo_mysql zip gd

# Composer をインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# プロジェクトをコピー
COPY . .

# Node ビルド成果物をコピー
COPY --from=node_builder /app/public/build ./public/build

# Composer 本番インストール
RUN composer install --no-dev --optimize-autoloader

# Laravel のキャッシュ最適化
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache


# -------- Supervisor（PHP-FPM + Nginx 同時起動） --------
COPY ./docker/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Nginx 設定
COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["/usr/bin/supervisord"]
