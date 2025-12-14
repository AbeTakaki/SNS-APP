# 使用スタック
Laravel 12.39.0  
php-fpm 8.4.11  
nginx 1.28  
MySQL 8.0  
Terraform 
AWS ECS Fargate  
Next.js 16.0.10 (App Router)  

# 要件定義
* 新規会員登録、ログイン、ログアウト
* つぶやき(CRUD)
* ユーザのフォロー、アンフォロー
* 特定ユーザーの1対1チャット
* プロフィール編集

# 開発環境の構築
コンテナを build & run する
```
docker compose up -d
```

ローカルホスト8080へアクセス  
http://localhost:8080/

# DB
```
<!-- php コンテナで実行 -->
php artisan migrate:fresh
php artisan db:seed --class=UserSeeder
php artisan db:seed --class XweetSeeder
<!-- SQL DBで実行 -->
insert into follows (following_user_id,followed_user_id,created_at,updated_at) values (1,2,now(),now());
insert into follows (following_user_id,followed_user_id,created_at,updated_at) values (1,3,now(),now());
insert into follows (following_user_id,followed_user_id,created_at,updated_at) values (1,4,now(),now());
insert into follows (following_user_id,followed_user_id,created_at,updated_at) values (2,1,now(),now());
insert into follows (following_user_id,followed_user_id,created_at,updated_at) values (2,4,now(),now());
insert into follows (following_user_id,followed_user_id,created_at,updated_at) values (3,4,now(),now());
insert into chats (user1_id,user2_id,created_at,updated_at) values (1,2,now(),now());
insert into messages (chat_id,mentioned_user_id,content,created_at,updated_at) values (1,1,'I am user1.',now(),now());
insert into messages (chat_id,mentioned_user_id,content,created_at,updated_at) values (1,2,'I am user2.',now(),now());
update users set profile="Student." where id=1;
```

# プロフィール画像の登録（ダミー）
```
insert into images (path,created_at,updated_at) values ('profile_icon.png',now(),now());
update users set profile_image_id=1 where id=1;

update images set path='profile_icon.jpeg' where id=1;
```

# テスト環境の用意
※ DB内にて
```
create database testing;
grant all on testing.* to laraveluser;
```
## .env.testingを作成  
- .env.exampleをコピーして作成
- .env.testingのDB周りの設定をテスト用に作成したDBに変更する

```mysql
# DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=testing
DB_USERNAME=testluser
DB_PASSWORD=testpassword
```

- アプリケーションキーの作成  
```
php artisan key:generate --env=testing
```

- testing データベースへのマイグレーションの実行
```
php artisan migrate --env=testing
```

## テスト時のコマンド
```
# 認証系
php artisan test tests/Feature/Auth/AuthenticationTest.php
php artisan test tests/Feature/Auth/RegistrationTest.php
# Xweet 関連
php artisan test tests/Feature/Xweet/XweetCreateTest.php
php artisan test tests/Feature/Xweet/XweetUpdateTest.php
php artisan test tests/Feature/Xweet/XweetDeleteTest.php
# Follow 関連
php artisan test tests/Feature/Follow/FollowStateTest.php
php artisan test tests/Feature/FollowAction/FollowActionTest.php
# Profile 関連
php artisan test tests/Feature/Profile/EditProfileTest.php
# Chat 関連
php artisan test tests/Feature/Chat/ChatTest.php
```
