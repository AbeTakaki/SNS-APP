<?php

namespace App\Http\Controllers\User\FollowAction;

use App\Http\Controllers\Controller;
use App\Services\FollowsService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class FollowUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request,
        string $userName,
        FollowsService $followsService,
        UserService $userService,
    ): JsonResponse
    {
        // ログインしているユーザーのIDを取得
        $following = Auth::id();
        // フォロー対象のidを取得
        $follower = $userService->getUserByUserName($userName)->resource->id;

        $followsService->createFollow($following, $follower);

        return response()->json([],Response::HTTP_CREATED);
    }
}
