# -------- Stage 1: Vite ビルド (Node) --------
FROM node:18 AS node_builder

# 作業ディレクトリ
WORKDIR /app

# 依存関係インストール
COPY package*.json ./
RUN npm install

# プロジェクト全体をコピー
COPY . .

# Vite 本番ビルド
RUN npm run build


# -------- Stage 2: PHP + Nginx + Supervisor --------
FROM php:8.3-fpm

# 必要なパッケージと拡張をインストール
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    unzip \
    git \
    libzip-dev \
    libpng-dev \
 && docker-php-ext-install pdo_mysql zip gd \
 && rm -rf /var/lib/apt/lists/*

# Composer をインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 作業ディレクトリ
WORKDIR /var/www/html

# プロジェクトファイルをコピー
COPY . .

# Node ビルド成果物（public/build）をコピー
COPY --from=node_builder /app/public/build ./public/build

# Laravel 用の権限調整
RUN chown -R www-data:www-data storage bootstrap/cache

# 本番向け Composer インストール
RUN composer install --no-dev --optimize-autoloader

# php-fpm が使うディレクトリを作る
RUN mkdir -p /run/php && chown -R www-data:www-data /run/php

# キャッシュ系（環境変数が揃ってないと失敗するので失敗しても無視する）
RUN php artisan config:clear || true \
 && php artisan config:cache || true \
 && php artisan route:cache || true \
 && php artisan view:cache || true

# Nginx 設定をコピー
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf

# Supervisor の設定をコピー
COPY docker/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Web ポート
EXPOSE 80

# Supervisor 経由で php-fpm と nginx を両方起動
CMD ["supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisor.conf"]
