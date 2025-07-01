windowsの場合 事前準備が必要　
WSL2を導入して　
ubuntuアプリをインストール　
参考：https://chigusa-web.com/blog/wsl2-win11/

powershellにて

インストール
wsl --install

確認
wsl -l -v

dockerの設定->resources->WSL2 integrationを有効化

ubuntuアプリをディレクトリを作って移動
mkdir projects && cd projects

git cloneする。それ以降は下記を実行。

# プロジェクトセットアップ手順 

この手順に従ってプロジェクトのセットアップを行ってください。

```bash
# プロジェクトのルートディレクトリに移動
cd fmx-supply-mgmt

# Dockerを使用してComposerの依存関係をインストール
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# .env.exampleをコピーして.envファイルを作成
cp .env.example .env

# Dockerコンテナをバックグラウンドで起動
./vendor/bin/sail up -d

# Sail環境でシェルにアクセス
./vendor/bin/sail shell

# Sailシェル内でComposer依存関係を再インストール
composer install

# Laravelアプリケーションキーを生成
php artisan key:generate

# データベースマイグレーションを実行
php artisan migrate

# Vue 3をインストール
npm install vue@3

# Viteプラグインをインストール
npm install @vitejs/plugin-vue

# 開発サーバーを起動
npm run dev

# ローカルサーバーにアクセス
http://localhost
