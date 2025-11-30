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
  <p>{{$profile}}</p>
  <button onClick="location.href='/user/{{$userName}}/follows'">フォローリストへ</button>
  <button onClick="location.href='/user/{{$userName}}/followers'">フォロワーリストへ</button>
  @if (\Illuminate\Support\Facades\Auth::id() !== $id)
    @if(!$isFollowing)
      {{-- フォロー --}}
      <div>
        <form action="/user/{{$userName}}/follow" method="post">
          @csrf
            <button type="submit">フォローする</button>
        </form>
      </div>
    @else
      {{-- アンフォロー --}}
      <div>
        <form action="/user/{{$userName}}/unfollow" method="post">
          @method('DELETE')
          @csrf
          <button type="submit">フォロー解除</button>
        </form>
      </div>
    @endif
      {{-- チャット開始 --}}
      <div>
          <form action="/user/{{$userName}}/chat" method="post">
              @csrf
              <button type="submit">チャットを開始</button>
          </form>
      </div>
  @else
    <div>
      <button onClick="location.href='/user/{{$userName}}/edit'">プロフィールを編集</button>
    </div>
  @endif

  @foreach ($xweets as $xweet)
    <p>{{ $xweet->content }} by {{ $xweet->getDisplayName() }} posted on {{ $xweet->created_at }}</p>
  @endforeach
</body>
</html>