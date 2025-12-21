<?php

namespace App\Http\Controllers\Xweet\Delete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\XweetService;
use Symfony\Component\HttpFoundation\Response;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, XweetService $xweetService): Response
    {
        $xweetId = (int)$request->route('xweetId');
        $xweet = $xweetService->getXweetById($xweetId)->resource;
        if(Auth::user()->cannot('delete', $xweet)) abort(403);
        $xweetService->deleteXweet($xweetId);
        return response()->noContent();
    }
}
