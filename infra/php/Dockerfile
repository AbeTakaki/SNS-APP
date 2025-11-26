FROM php:8.4-fpm-bullseye

# composer ベースイメージからバイナリをコピー（マルチステージビルド）
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# ライブラリのインストール
RUN apt-get update && \
    apt-get -y install --no-install-recommends git unzip libzip-dev libicu-dev libonig-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install intl pdo_mysql zip bcmath && \
    groupadd gphp && \
    useradd php -g gphp

# デフォルト命令を実行するユーザをrootからphpユーザに変更
USER php

# 作業ディレクトリを設定
WORKDIR /var/www/html
# ホストOSの /src の中身をコピー&所有者変更
COPY --chown=php:gphp ./src /var/www/html/

# storage,bootstrap/cacheはwebサーバーから書き込み可能にする
RUN chmod -R 755 storage bootstrap/cache