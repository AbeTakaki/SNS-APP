<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MakeChatRoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $userName): RedirectResponse
    {
        $user1 = Auth::id();
        $user = User::where('user_name',$userName)->firstOrFail();
        $user2 = $user->id;

        if($user1 > $user2){
            $tmp = $user1;
            $user1 = $user2;
            $user2 = $tmp;
        }

        $room = Chat::where([
            ['user1_id', $user1],
            ['user2_id', $user2],
        ])->first();

        // チャットルームがある場合は、そのチャットルームへりダイレクト
        // ない場合は部屋を作成する
        if($room){
            return redirect()->route('chat.index',['chatId'=>$room->id]);
        }else{
            $room = new Chat;
            $room->user1_id=$user1;
            $room->user2_id=$user2;
            $room->save();
            return redirect()->route('chat.index',['chatId'=>$room->id]);
        }
    }
}
