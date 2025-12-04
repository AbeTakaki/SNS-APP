<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ChatService;
use App\Services\MessageService;
use App\Services\UserService;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request,
        int $chatId,
        ChatService $chatService,
        UserService $userService,
        MessageService $messageService,
    ): View
    {
        $chat = $chatService->getChatById($chatId);
        if(Auth::user()->cannot('enter', $chat)) abort(403);
        $user1 = $userService->getUserById($chat->user1_id);
        $user2 = $userService->getUserById($chat->user2_id);
        $users = array($user1->display_name,$user2->display_name);
        $messages = $messageService->getMessagesByChatId($chatId);

        return view('chat.index')->with([
            'chatId'=>$chatId,
            'users'=>$users,
            'messages' => $messages,
        ]);
    }
}
