<?php

namespace App\Http\Controllers\Xweet\Create;

use App\Http\Controllers\Controller;
use App\Http\Requests\Xweet\CreateRequest;
use App\Services\XweetService;
use Illuminate\Http\JsonResponse;
use \Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateRequest $request, XweetService $xweetService) : JsonResponse
    {
        $xweetService->createXweet($request->getUserId(), $request->getXweet());
        return response()->json([],Response::HTTP_CREATED);
    }
}
