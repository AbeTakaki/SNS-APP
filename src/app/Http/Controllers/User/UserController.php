<?php

namespace App\Http\Controllers\User;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Xweet;

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

        return view('user.index')->with([
            'userName' => $user->user_name,
            'displayName' => $user->display_name,
            'xweets' => $xweets,
        ]);
    }
}
