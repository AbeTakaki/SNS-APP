<?php

namespace App\Http\Controllers\User\FollowAction;

use App\Http\Controllers\Controller;
use App\Models\Follows;
use App\Models\User;
use App\Services\FollowsService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

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
    ): RedirectResponse
    {
        // ログインしているユーザーのIDを取得
        $following = Auth::id();
        // フォロー対象のidを取得
        $follower = $userService->getUserByUserName($userName)->id;

        $followsService->createFollow($following, $follower);

        return redirect()->route('user.index', ['userName'=>$userName]);
    }
}
