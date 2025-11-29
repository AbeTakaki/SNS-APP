<?php

namespace App\Http\Controllers\Xweet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Xweet;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function __invoke(Request $request) : View
    {
        $xweets = Xweet::all();

        return view('xweet.index')->with([
            'userName' => 'user1',
            'xweets' => $xweets,
        ]);
    }
}
