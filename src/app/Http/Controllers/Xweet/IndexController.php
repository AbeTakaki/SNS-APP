<?php

namespace App\Http\Controllers\Xweet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Xweet;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class IndexController extends Controller
{
    public function __invoke(Request $request) : View
    {
        $xweets = Xweet::all();

        $loginId = Auth::id();
        if ($loginId) {
            $loginUser = User::where('id', $loginId)->first();
            return view('xweet.index')->with([
                'userName' => $loginUser->user_name,
                'xweets' => $xweets,
            ]);
        } else {
            return view('xweet.index')->with([
                'xweets' => $xweets,
            ]);
        }
    }
}
