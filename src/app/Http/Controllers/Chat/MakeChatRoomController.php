<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ChatService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MakeChatRoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        string $userName,
        ChatService $chatService,
        UserService $userService,
    ): JsonResponse
    {
        $user1 = Auth::id();
        $user2 = $userService->getUserByUserName($userName)->id;

        $chatRoomId = $chatService->createChatRoom($user1, $user2);
        return response()->json(['chatId'=>$chatRoomId],Response::HTTP_OK);
    }
}
