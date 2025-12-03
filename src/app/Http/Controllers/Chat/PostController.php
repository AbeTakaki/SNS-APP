<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Message\CreateRequest;
use App\Models\Message;
use App\Models\Chat;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateRequest $request): RedirectResponse
    {
        $chatId=$request->getChatId();
        $chat=Chat::where('id',$chatId)->firstOrFail();
        if(Auth::user()->cannot('enter', $chat)) abort(403);
        $message = new Message;
        $message->chat_id=$chatId;
        $message->mentioned_user_id=Auth::id();
        $message->content=$request->getMessage();
        $message->save();
        return redirect()->route('chat.index',['chatId'=>$chatId]);
    }
}
