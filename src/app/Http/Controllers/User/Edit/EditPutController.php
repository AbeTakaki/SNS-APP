<?php

namespace App\Http\Controllers\User\Edit;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\EditRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class EditPutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EditRequest $request, string $userName): RedirectResponse
    {
        $quser = User::where('user_name',$userName)->firstOrFail();
        if(Auth::id() === $quser->id){
            $quser->display_name = $request->getInput1();
            $quser->profile = $request->getInput2();
            $quser->save();
            return redirect()->route('user.index',['userName'=>$userName]);
        }else{
            abort(403);
        }
    }
}
