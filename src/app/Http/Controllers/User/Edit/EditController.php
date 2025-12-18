<?php

namespace App\Http\Controllers\User\Edit;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $userName, UserService $userService): JsonResponse
    {
        $user = $userService->getUserByUserName($userName);
        if(Auth::user()->cannot('update',$user)) abort(403);
        return response()->json([
            'userName' => $user->user_name,
            'displayName' => $user->display_name,
            'profile' => $user->profile
       ]);
    }
}
