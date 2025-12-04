<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Follows;
use App\Models\User;
use App\Services\UserService;
use Illuminate\View\View;

class FollowersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $userName, UserService $userService): View
    {
        $user = $userService->getUserByUserName($userName);
        $users = $userService->getFollowersProfiles($user->id);

        return view('user.followers')->with([
            'displayName' => $user->display_name,
            'users' => $users,
        ]);
    }
}
