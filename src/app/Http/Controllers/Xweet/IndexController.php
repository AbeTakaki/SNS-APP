<?php

namespace App\Http\Controllers\Xweet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\XweetService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    public function __invoke(Request $request, XweetService $xweetService, UserService $userService) : JsonResponse
    {
        if ($request->id) {
            $loginId = $request->id;
            $xweets = $xweetService->getFollowsXweets($loginId);
            $loginUserName = $userService->getUserById($loginId)->user_name;

            return response()->json([
                'userName' => $loginUserName,
                'xweets' => $xweets,
            ]);
        } else {
            $xweets = $xweetService->getAllXweets();
            return response()->json([
                'xweets' => $xweets,
            ]);
        }
    }
}
