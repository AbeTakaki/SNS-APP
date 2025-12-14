<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'error' => '認証に失敗しました。',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $token = $user->createToken('AccessToken')->plainTextToken;
        return response()->json(['token' => $token], Response::HTTP_CREATED);
    }

    public function user (Request $request): JsonResponse
    {
        return response()->json(
            [
                'id' => $request->user()->id,
                'user_name' => $request->user()->user_name,
                'display_name' => $request->user()->display_name,
                'email' => $request->user()->email,
                'profile' => $request->user()->profile,
            ], Response::HTTP_OK
        );
    }

    public function logout(Request $request): JsonResponse
    {
        PersonalAccessToken::findToken($request->bearerToken())->delete();
        return response()->json(['message' => 'ログアウトしました。'], Response::HTTP_CREATED);
    }
}
