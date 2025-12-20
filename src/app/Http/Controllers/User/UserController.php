<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FollowsService;
use App\Services\UserService;
use App\Services\XweetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
    ) : JsonResponse
    {
        $user = $userService->getUserByUserName($userName)->resource;
        $xweets = $xweetService->getUserXweets($user->id);
        
        $isFollowing = false;
        $following = $request->id;
        if ($following){
            $follower = $user->id;
            $isFollowing = $followsService->isFollow($following, $follower);
        }

        $imagePath = null;
        if($user->profile_image_id) {
            $imagePath = $user->getImagePath();
        }

        return response()->json([
            'id' => $user->id,
            'userName' => $user->user_name,
            'displayName' => $user->display_name,
            'profile' => $user->profile,
            'imagePath' => $imagePath,
            'xweets' => $xweets,
            'isFollowing' => $isFollowing,
        ], Response::HTTP_OK);
    }
}
