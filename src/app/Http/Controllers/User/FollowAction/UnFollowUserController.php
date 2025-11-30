<?php

namespace App\Http\Controllers\User\FollowAction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follows;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class UnFollowUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $userName): RedirectResponse
    {
        $following = Auth::id();
        $user = User::where('user_name', $userName)->firstOrFail();
        $follower = $user->id;

        $follows = Follows::where([
            ['following_user_id', $following],
            ['followed_user_id', $follower],
        ])->firstOrFail();

        $follows->delete();
        return redirect()->route('user.index', ['userName'=>$userName]);
    }
}
