<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Message\CreateRequest;
use App\Models\Message;
use App\Models\Chat;
use App\Services\ChatService;
use App\Services\MessageService;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        CreateRequest $request,
        int $chatId,
        ChatService $chatService,
        MessageService $messageService,
    ): RedirectResponse
    {
        $chatId = $request->getChatId();
        $chat = $chatService->getChatById($chatId);
        if(Auth::user()->cannot('enter', $chat)) abort(403);
        $messageService->createMessage($chatId,Auth::id(),$request->getMessage());
        return redirect()->route('chat.index',['chatId'=>$chatId]);
    }
}
