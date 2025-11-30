<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Follows;
use App\Models\User;
use Illuminate\View\View;

class FollowersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $userName): View
    {
        $user = User::where('user_name', $userName)->firstOrFail();
        $relations = Follows::where('followed_user_id', $user->id)->get();
        $users = [];
        foreach($relations as $relation) {
            $user = User::where('id', $relation->following_user_id)->first();
            array_push($users,$user);
        }

        return view('user.followers')->with([
            'displayName' => $user->display_name,
            'users' => $users,
        ]);
    }
}
