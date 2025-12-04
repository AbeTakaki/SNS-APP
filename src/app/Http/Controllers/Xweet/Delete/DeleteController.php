<?php

namespace App\Http\Controllers\Xweet\Delete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Xweet;
use App\Services\XweetService;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, XweetService $xweetService)
    {
        $xweetId = (int)$request->route('xweetId');
        $xweet = $xweetService->getXweetById($xweetId);
        if(Auth::user()->cannot('delete', $xweet)) abort(403);
        $xweetService->deleteXweet($xweetId);
        return redirect()->route('xweet.index');
    }
}
