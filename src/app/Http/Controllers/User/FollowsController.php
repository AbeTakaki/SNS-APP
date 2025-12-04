<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\View\View;

class FollowsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $userName, UserService $userService): View
    {
        $user = $userService->getUserByUserName($userName);
        $users = $userService->getFollowsProfiles($user->id);

        return view('user.follows')->with([
            'displayName' => $user->display_name,
            'users' => $users,
        ]);
    }
}
