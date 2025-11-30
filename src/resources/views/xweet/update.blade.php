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
  <div>
    <p>Xweet編集画面</p>
    <form action="{{route('xweet.update.put', ['xweetId' => $xweet->id])}}" method="POST">
      @csrf
      @method('PUT')
      <textarea id="xweet-content" type="text" name="xweet">{{$xweet->content}}</textarea>
      <button type="submit">更新</button>
    </form>
  </div>
</body>
</html>