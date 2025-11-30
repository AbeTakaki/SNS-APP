<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follows;
use Illuminate\View\View;

class FollowsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $userName): View
    {
        $user = User::where('user_name', $userName)->firstOrFail();
        $relations = Follows::where('following_user_id', $user->id)->get();
        $users = array();
        foreach ($relations as $relation) {
            $user = User::where('id', $relation->followed_user_id)->first();
            array_push($users,$user);
        }

        return view('user.follows')->with([
            'displayName' => $user->display_name,
            'users' => $users,
        ]);
    }
}
