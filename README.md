# BrushEdit
文章管理・編集アプリ

## 概要
BrushEdit は文章を作成・管理・編集できる Web アプリケーションです。  
ディレクトリ管理、タグ検索、自動保存、プレビュー機能などを備え、  
執筆の作業効率を向上させることを目的にしています。

現状はまだ開発途中ですが、最終的には「文章の推敲支援アプリ」として  
より機能を充実させることを目標にしています。

---

## 主な機能
- ユーザー登録 / ログイン / ログアウト  
- プロフィール編集 / アカウント削除（モーダル式 UI）  
- 文章の作成 / 編集 / 削除  
- ディレクトリ構造による文書整理  
- タグ付け・タグ検索  
- プレビュー（フォント・サイズ・文字色・背景色切り替え）  
- 入力内容の自動保存  
- 文字数カウント  
（※レスポンシブ対応は今後実装予定です）

---

## 使用技術 🛠️

### Backend
- Laravel 10  
- PHP 8.3  
- PostgreSQL（Render）

### Frontend
- Vite  
- JavaScript  
- カスタム CSS  
- Alpine.js（一部機能）

### DevOps / Infra
- Docker（マルチステージビルド）  
- Nginx（静的ファイル配信 / FastCGI）  
- php-fpm  
- Supervisor（nginx / php-fpm のプロセス管理）  
- Render（Web Service / Database）

Renderを選択したことにより、構築過程でインフラにも触れることになり、
試行錯誤しながらデプロイまで辿り着きました。  
本番環境の構成については下記に詳しくまとめています。

---

## プロジェクト構成（本番環境）

### アーキテクチャ

```
ユーザー（HTTPS）
       ↓
Render Reverse Proxy
       ↓ （HTTP）
------------------------------------------------
Nginx（Docker コンテナ内）
       ├─ 静的ファイル：/public/build
       └─ php-fpm（Laravel アプリケーション）
                       ↓
                PostgreSQL（Render）
```

---

### 本番ビルドの流れ
1. Node で Vite を本番ビルド  
2. 生成された build アーティファクトを Docker イメージへコピー  
3. Supervisor 経由で nginx + php-fpm を起動  
4. Render の Reverse Proxy（X-Forwarded-Proto）を nginx に渡す  
5. Laravel 側で HTTPS を正しく認識させ、Mixed Content を回避

---

### Docker マルチステージのポイント
- Node イメージで Vite をビルド  
- PHP イメージへ `/public/build` をコピー  
- dev 依存を含まない軽量コンテナを生成  

---

### Nginx のポイント
- `/build/` は alias + try_files =404 で静的ファイル扱い  
- Reverse Proxy 対応のため `X-Forwarded-Proto` を php-fpm に渡す  
- `try_files $uri $uri/ /index.php` により Laravel 側へルーティング  

---

## ローカル開発環境のセットアップ

```bash
# クローン
git clone https://github.com/x0u6x/brush-edit.git
cd brush-edit

# .env 作成
cp .env.example .env
php artisan key:generate

# PHP 依存
composer install

# Node 依存
npm install
npm run dev

# DB 準備
php artisan migrate

# 起動
php artisan serve
```

---

## 本番環境（Render）での動作

- Web Service は Dockerfile から自動ビルド  
- PostgreSQL は Render のマネージドDBを使用  
- Environment Variables に `APP_KEY`, `DB_*` などを設定  
- デプロイ時は旧コンテナ停止 → 新コンテナ起動  
- Mixed Content 回避のため nginx と Laravel が HTTPS を正しく認識  

---

## 環境変数（Render）
以下の環境変数を Render の Environment Settings に設定します。

- APP_ENV  
- APP_DEBUG  
- APP_KEY  
- APP_URL  
- DATABASE_URL  
- DB_CONNECTION  
- DB_HOST  
- DB_PORT  
- DB_DATABASE  
- DB_USERNAME  
- DB_PASSWORD  

---

## ライセンス
本リポジトリのコードは著作権法により保護されています。  
無断転載・再配布はご遠慮ください。
