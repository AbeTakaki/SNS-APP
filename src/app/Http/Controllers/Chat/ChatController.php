<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $chatId)
    {
        $userId=Auth::id();
        $chat=Chat::where('id',$chatId)->firstOrFail();
        if($chat->user1_id===$userId || $chat->user2_id===$userId){
            $user1=User::where('id',$chat->user1_id)->firstOrFail();
            $user2=User::where('id',$chat->user2_id)->firstOrFail();
            $users=array($user1->display_name,$user2->display_name);
            $messages = Message::where('chat_id', $chatId)->get();

            return view('chat.index')->with([
                'chatId'=>$chatId,
                'users'=>$users,
                'messages' => $messages,
            ]);
        }else{
            abort(403);
        }
    }
}
