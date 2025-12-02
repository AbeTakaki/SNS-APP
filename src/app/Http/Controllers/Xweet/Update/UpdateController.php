<?php

namespace App\Http\Controllers\Xweet\Update;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Xweet;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) : View
    {
        $xweetId = (int)$request->route('xweetId');
        $xweet = Xweet::where('id', $xweetId)->firstOrFail();
        if(Auth::user()->cannot('update', $xweet)) abort(403);
        return view('xweet.update')->with('xweet',$xweet);
    }
}
