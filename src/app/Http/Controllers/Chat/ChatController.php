<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $chatId): View
    {
        $chat=Chat::where('id',$chatId)->firstOrFail();
        if(Auth::user()->cannot('enter', $chat)) abort(403);
        $user1=User::where('id',$chat->user1_id)->firstOrFail();
        $user2=User::where('id',$chat->user2_id)->firstOrFail();
        $users=array($user1->display_name,$user2->display_name);
        $messages = Message::where('chat_id', $chatId)->get();

        return view('chat.index')->with([
            'chatId'=>$chatId,
            'users'=>$users,
            'messages' => $messages,
        ]);
    }
}
