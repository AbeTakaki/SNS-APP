<?php

namespace App\Http\Controllers\User;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Xweet;
use App\Models\Follows;

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
    public function __invoke(Request $request, string $userName) : View
    {
        $user = User::where('user_name', $userName)->firstOrFail();
        $xweets = Xweet::where('user_id', $user->id)->get();
        $following = Auth::id();
        $follower = $user->id;
        $follows = Follows::where([
            ['following_user_id', $following],
            ['followed_user_id', $follower],
        ])->first();

        $isFollowing = false;
        if($follows) $isFollowing = true;

        return view('user.index')->with([
            'id' => $user->id,
            'userName' => $user->user_name,
            'displayName' => $user->display_name,
            'profile' => $user->profile,
            'xweets' => $xweets,
            'isFollowing' => $isFollowing,
        ]);
    }
}
