<?php

namespace App\Http\Controllers\User;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FollowsService;
use App\Services\UserService;
use App\Services\XweetService;

/**
 * Class UserController
 *
 * ユーザページの表示を担当するコントローラ。
 */
class UserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request,
        string $userName,
        UserService $userService,
        XweetService $xweetService,
        FollowsService $followsService
    ) : View
    {
        $user = $userService->getUserByUserName($userName);
        $xweets = $xweetService->getUserXweets($user->id);
        
        $isFollowing = false;
        $following = Auth::id();
        if ($following){
            $follower = $user->id;
            $isFollowing = $followsService->isFollow($following, $follower);
        }

        $imagePath = null;
        if($user->profile_image_id) {
            $imagePath = $user->getImagePath();
        }

        return view('user.index')->with([
            'id' => $user->id,
            'userName' => $user->user_name,
            'displayName' => $user->display_name,
            'profile' => $user->profile,
            'imagePath' => $imagePath,
            'xweets' => $xweets,
            'isFollowing' => $isFollowing,
        ]);
    }
}
