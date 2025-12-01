@props([
    'xweet'=>[],
])

<form action="{{route('xweet.update.put',['xweetId'=>$xweet->id])}}" method="post">
    @method('PUT')
    @csrf
    <textarea 
        id="xweet-content" 
        rows="3"
        type="text" 
        name="xweet"
        class="focus:ring-blue-400 focus:border-blue-400 mt-1 block w-full text:text-sm border border-gray-300 rounded-md p-2"
        placeholder="つぶやきを入力">{{$xweet->content}}</textarea>
    @error('xweet')
        <p style="color:red;">{{$message}}</p>
    @enderror
    <div class="flex flex-wrap justify-end">
        <x-element.button-post>編集</x-element.button-post>
    </div>
</form>