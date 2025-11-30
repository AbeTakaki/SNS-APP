<?php

namespace App\Http\Controllers\Xweet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Xweet;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Follows;

class IndexController extends Controller
{
    public function __invoke(Request $request) : View
    {
        $loginId = Auth::id();

        if ($loginId) {
            $users =  Follows::where('following_user_id', $loginId)->get();
            $followUserIds = array(
                0 => (int)$loginId,
            );

            foreach($users as $user) {
                $followUserIds[] = $user->followed_user_id;
            }

            $xweets = Xweet::whereIn('user_id', $followUserIds)->orderBy('created_at','DESC')->get();

            $loginUser = User::where('id', $loginId)->first();
            return view('xweet.index')->with([
                'userName' => $loginUser->user_name,
                'xweets' => $xweets,
            ]);
        } else {
            $xweets = Xweet::orderBy('created_at','DESC')->get();
            return view('xweet.index')->with([
                'xweets' => $xweets,
            ]);
        }
    }
}
