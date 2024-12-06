# もぎたて

## Dockerビルド
1. リポジトリの複製<br>`git clone git@github.com:NaoyaNoro/fashinablylove.git`
2. DockerDesktopアプリを立ち上げる
3. dockerをビルドする<br>`docker-compose up -d --build`
>3を実行するときに，`no matching manifest for linux/arm64/v8 in the manifest list entries` というようなエラーが出ることがあります。この場合，docker-compose.ymlのmysqlサービスとphp myadminのサービスの箇所に `platform: linux/amd64` というような表記を追加してください

## Laravel環境構築
1. PHPコンテナ内にログインする <br>`docker-compose exec php bash`
2. composerコマンドを使って必要なコマンドのインストール <br>`composer install`
3. .env.exampleファイルから.envを作成 <br>`cp .env.example .env`
4. 環境変数を変更<br>
   ```
   DB_HOST=mysql
   DB_PORT=3306 
   DB_DATABASE=laravel_db
   DB_USERNAME=laravel_user
   DB_PASSWORD=laravel_pass
   ```  
5. アプリケーションキーの作成<br> `php artisan key:generate`
6. マイグレーションの実行<br> `php artisan migrate`
7. シーディングの実行<br> `php artisan db:seed`

## 使用技術
* php 7.4.9
* Laravel 8.83.8
* MySQL 8.0.26

## ER図
![er(mogitate)](https://github.com/user-attachments/assets/03cdf611-1287-44e1-be66-4a9ef2662075)


## URL
* 開発環境:http://localhost
* phpmyadmin:http://localhost:8080/
