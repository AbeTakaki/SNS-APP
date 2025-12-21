<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FollowsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $userName, UserService $userService): JsonResponse
    {
        $user = $userService->getUserByUserName($userName)->resource;
        $users = $userService->getFollowsProfiles($user->id);

        return response()->json([
            'displayName' => $user->display_name,
            'users' => $users,
        ],Response::HTTP_OK);
    }
}
