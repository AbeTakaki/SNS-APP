<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ChatService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;

class MakeChatRoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request,
        string $userName,
        ChatService $chatService,
        UserService $userService,
    ): RedirectResponse
    {
        $user1 = Auth::id();
        $user2 = $userService->getUserByUserName($userName)->id;

        $chatRoomId = $chatService->createChatRoom($user1, $user2);
        return redirect()->route('chat.index',['chatId' => $chatRoomId]);
        
    }
}
