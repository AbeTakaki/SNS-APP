<?php

namespace App\Http\Controllers\User\Edit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\View\View;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $userName): View
    {
        $user = User::where('user_name',$userName)->firstOrFail();
        if(Auth::user()->cannot('update',$user)) abort(403);
        return view('user.edit')->with([
            'userName' => $user->user_name,
            'displayName' => $user->display_name,
            'profile' => $user->profile
       ]);
    }
}
