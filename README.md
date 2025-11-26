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
