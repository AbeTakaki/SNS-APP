<?php

namespace App\Http\Controllers\Xweet\Delete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Xweet;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $userId = Auth::id();
        $xweetId = (int)$request->route('xweetId');
        $xweet = Xweet::where('id', $xweetId)->firstOrFail();
        if(Auth::user()->cannot('delete', $xweet)) abort(403);
        $xweet->delete();
        return redirect()->route('xweet.index');
    }
}
