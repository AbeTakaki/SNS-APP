<?php

namespace App\Http\Controllers\Xweet\Update;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\XweetService;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, XweetService $xweetService) : View
    {
        $xweetId = (int)$request->route('xweetId');
        $xweet = $xweetService->getXweetById($xweetId);
        if(Auth::user()->cannot('update', $xweet)) abort(403);
        return view('xweet.update')->with('xweet',$xweet);
    }
}
