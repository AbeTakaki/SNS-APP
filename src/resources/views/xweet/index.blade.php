<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" >
  <title>Xweet</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
  <h1>Xweet</h1>
  <!-- ログイン状態のとき表示 -->
  @if(\Illuminate\Support\Facades\Auth::check())
    <button onClick="location.href='/xweet/create'">Xweet作成画面へ</button>
    <button onClick="location.href='/user/{{$userName}}'">マイページへ</button>
  @endif
  <hr>
  @foreach ($xweets as $xweet)
    {{ $xweet->content }} by {{ $xweet->getDisplayName() }} posted on {{ $xweet->created_at }}
    @if(\Illuminate\Support\Facades\Auth::id() === $xweet->user_id)
      <a href="{{route('xweet.update',['xweetId'=>$xweet->id])}}">更新</a>
    @endif
    <br>
  @endforeach
</html>