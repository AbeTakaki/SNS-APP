<?php

namespace App\Http\Controllers\Xweet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Xweet;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Follows;
use App\Services\XweetService;
use App\Services\UserService;

class IndexController extends Controller
{
    public function __invoke(Request $request, XweetService $xweetService, UserService $userService) : View
    {
        $loginId = Auth::id();

        if ($loginId) {
            $xweets = $xweetService->getFollowsXweets($loginId);
            $loginUserName = $userService->getUserById($loginId)->user_name;

            return view('xweet.index')->with([
                'userName' => $loginUserName,
                'xweets' => $xweets,
            ]);
        } else {
            $xweets = $xweetService->getAllXweets();
            return view('xweet.index')->with([
                'xweets' => $xweets,
            ]);
        }
    }
}
