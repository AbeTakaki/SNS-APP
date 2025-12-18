<?php

namespace App\Http\Controllers\Xweet\Update;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\XweetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, XweetService $xweetService) : JsonResponse
    {
        $xweetId = (int)$request->route('xweetId');
        $xweet = $xweetService->getXweetById($xweetId)->resource;
        if(Auth::user()->cannot('update', $xweet)) abort(403);
        return response()->json(['xweet'=>$xweet,],Response::HTTP_OK);
    }
}
