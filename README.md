# 使用スタック
Laravel 12.x  
php-fpm 8.4  
nginx 1.28  
MySQL 8.0  
Terraform 1.12.2  
Terraform AWS Provider 5.100.0  
AWS ECS Fargate  
Next.js 15.3.4 (App Router)  

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
