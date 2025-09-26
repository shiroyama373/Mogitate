# Mogitate (フリマアプリ)

## 環境構築

### Docker ビルド

```bash
git clone <https://github.com/shiroyama373/Mogitate.git >
docker-compose up -d --build

注意: MySQL は OS によって起動しない場合があります。その場合は、docker-compose.yml を編集し、環境に合わせて調整してください。

Laravel 環境構築
docker-compose exec php bash
composer install
cp .env.example .env   # 環境変数の設定
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link

注意: .env ファイルの DB_DATABASE、DB_USERNAME、DB_PASSWORD は docker-compose.yml に合わせて設定してください。
ユーザー情報は src/database/seeders/UsersTableSeeder.php に記載されています。

使用技術
	•	PHP: 8.2.29
	•	Laravel: 10.48.29
	•	MySQL:  8.0.43

URL
	•	開発環境: http://localhost:8080/
	•	phpMyAdmin: http://localhost:8081/

⸻

複数ユーザーの同時ログインについて

同じブラウザで複数ユーザーを同時にログインして別タブで確認すると、最後にログインしたユーザーにセッションが切り替わります。
異なるユーザーで動作確認する場合は以下を推奨します:
	1.	シークレットウィンドウ (Chrome: Ctrl+Shift+N)
	2.	別ブラウザ (Chrome / Edge / Firefox など)

機能一覧

機能            URL
商品一覧         /products
商品詳細         /products/{productId}
商品更新         /products/{productId}/update
商品登録         /products/register
検索            /products/search （※未使用）
削除            /products/{productId}/delete
※/products/search は現時点では未使用です。
※ 検索や並び替えは /products に対して GET パラメータとして処理しています。

## ER 図

![ER図](docs/mogitate.drawio.svg)
