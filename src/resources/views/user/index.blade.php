<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xweet</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  <h1>Xweet</h1>
  <h2>{{ $displayName }}さんのページ</h2>
  <button onClick="location.href='/user/{{$userName}}/follows'">フォローリストへ</button>
  <button onClick="location.href='/user/{{$userName}}/followers'">フォロワーリストへ</button>
  @foreach ($xweets as $xweet)
    <p>{{ $xweet->content }} by {{ $xweet->getDisplayName() }} posted on {{ $xweet->created_at }}</p>
  @endforeach
</body>
</html>