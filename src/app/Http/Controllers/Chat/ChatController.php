<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ChatService;
use App\Services\MessageService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        int $chatId,
        ChatService $chatService,
        UserService $userService,
        MessageService $messageService,
    ): JsonResponse
    {
        $chat = $chatService->getChatById($chatId);
        if(Auth::user()->cannot('enter', $chat)) abort(403);
        $user1 = $userService->getUserById($chat->user1_id);
        $user2 = $userService->getUserById($chat->user2_id);
        $users = array($user1->display_name,$user2->display_name);
        $messages = $messageService->getMessagesByChatId($chatId);

        return response()->json([
            'chatId'=>$chatId,
            'users'=>$users,
            'messages' => $messages,
        ],Response::HTTP_OK);
    }
}
