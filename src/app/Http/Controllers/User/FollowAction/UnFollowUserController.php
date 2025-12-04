<?php

namespace App\Http\Controllers\User\FollowAction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FollowsService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;

class UnFollowUserController extends Controller
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
        $following = Auth::id();
        $follower = $userService->getUserByUserName($userName)->id;

        $followsService->deleteFollow($following, $follower);
        return redirect()->route('user.index', ['userName'=>$userName]);
    }
}
