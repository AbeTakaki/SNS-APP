<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" >
  <title>Xweet</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
  <h1>Xweet作成画面</h1>
  <div>
    <form action="/xweet/create" method="POST">
      @csrf 
      <textarea id="xweet-content" type="text" name="xweet"></textarea>
      <button type="submit">投稿</button>
    </form>
  </div>
</body>
</html>