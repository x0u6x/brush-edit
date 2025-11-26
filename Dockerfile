# -------- Stage 1: Build Vite assets (Node) --------
FROM node:18 AS node_builder

# 作業ディレクトリ
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
    && docker-php-ext-install pdo_mysql zip gd

# Composer をインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 作業ディレクトリ
WORKDIR /var/www/html

# プロジェクトファイルをコピー
COPY . .

# Node ビルド成果物（public/build）をコピー
COPY --from=node_builder /app/public/build ./public/build

# Composer 本番インストール
RUN composer install --no-dev --optimize-autoloader

# Laravel キャッシュ最適化
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

EXPOSE 9000

# PHP-fpm で起動
CMD ["php-fpm"]


# -------- Stage 3: Nginx --------
FROM nginx:1.25

# Laravel プロジェクトをコピー
COPY --from=php_runtime /var/www/html /var/www/html

# Nginx の config を置く
COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
