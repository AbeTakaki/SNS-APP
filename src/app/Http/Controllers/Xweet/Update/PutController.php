<?php

namespace App\Http\Controllers\Xweet\Update;

use App\Http\Controllers\Controller;
use App\Http\Requests\Xweet\UpdateRequest;
use App\Services\XweetService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class PutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $request, XweetService $xweetService) : RedirectResponse
    {
        $xweet = $xweetService->getXweetById($request->getId());
        if(Auth::user()->cannot('update', $xweet)) abort(403);
        $xweetService->updateXweet($request->getId(), $request->getXweet());
        return redirect()->route('xweet.index');
    }
}
