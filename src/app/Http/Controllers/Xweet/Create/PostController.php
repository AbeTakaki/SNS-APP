<?php

namespace App\Http\Controllers\Xweet\Create;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Xweet\CreateRequest;
use App\Services\XweetService;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateRequest $request, XweetService $xweetService) : RedirectResponse
    {
        $xweetService->createXweet($request->getUserId(), $request->getXweet());
        return redirect()->route('xweet.index');
    }
}
