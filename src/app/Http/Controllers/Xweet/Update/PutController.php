<?php

namespace App\Http\Controllers\Xweet\Update;

use App\Http\Controllers\Controller;
use App\Http\Requests\Xweet\UpdateRequest;
use App\Services\XweetService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $request, XweetService $xweetService) : Response
    {
        $xweet = $xweetService->getXweetById($request->getId())->resource;
        if(Auth::user()->cannot('update', $xweet)) abort(403);
        $xweetService->updateXweet($request->getId(), $request->getXweet());
        return response()->noContent();
    }
}
