@props([
    'xweets'=>[],
])

<div class="bg-white rounded-md shadow-lg mt-5 mb-5 overflow-auto">
    <ul>
        @foreach($xweets as $xweet)
        <li class="border-b last:border-0 border-gray-200 p-4">
            <span class="inline-block rounded-full px-2 py-1 text-s font-bold mb-1">
                <a href="{{route('user.index',['userName'=>$xweet->getUserName()])}}">{{$xweet->getDisplayName()}}</a> 
            </span>
            
            <p class="text-gray-600 px-2 mb-1">{!!nl2br(e($xweet->content))!!}</p>
            <p class="text-xs text-right">posted on {{$xweet->created_at}}</p>
            
            @if(\Illuminate\Support\Facades\Auth::id()===$xweet->user_id)
            <div class="mt-2 text-xs text-right">
                <span class="mr-1"><a href="{{route('xweet.update',['xweetId'=>$xweet->id])}}">更新</a></span>
                <form style="display:inline" action="{{route('xweet.delete',['xweetId'=>$xweet->id])}}" method="post">
                    @method('DELETE')
                    @csrf
                    <button type="submit">削除</button>
                </form>
            </div>
            @endif
            
        </li>
        @endforeach
    </ul>
</div>