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
    public function __invoke(Request $request) : View | abort
    {
        $userId = Auth::id();
        $xweetId = (int)$request->route('xweetId');
        $xweet = Xweet::where('id', $xweetId)->firstOrFail();
        if ($userId === $xweet->user_id) {
            return view('xweet.update')->with('xweet',$xweet);
        } else {
            abort(403);
        }
    }
}
