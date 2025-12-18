<?php

namespace App\Http\Controllers\User\Edit;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $userName, UserService $userService): JsonResponse
    {
        $user = $userService->getUserByUserName($userName)->resource;
        if(Auth::user()->cannot('update',$user)) abort(403);
        return response()->json([
            'id' => $user->id,
            'user_name' => $user->user_name,
            'display_name' => $user->display_name,
            'profile' => $user->profile,
            'profile_image_id' => $user->profile_image_id,
       ],Response::HTTP_OK);
    }
}
