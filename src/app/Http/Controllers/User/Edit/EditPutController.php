<?php

namespace App\Http\Controllers\User\Edit;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\EditRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class EditPutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EditRequest $request, string $userName): RedirectResponse
    {
        $user = User::where('user_name',$userName)->firstOrFail();
        if(Auth::id() === $user->id){
            $user->display_name = $request->getInput1();
            $user->profile = $request->getInput2();
            
            if($request->getInput3()){
                $str=Storage::disk('public')->putFile('',$request->getInput3());

                $image=new Image;
                $image->path=$str;
                $image->save();

                if($user->profile_image_id){
                    $oldImage=Image::where('id',$user->profile_image_id)->first();
                    $user->profile_image_id=$image->id;
                    $user->save();
                    Storage::disk('public')->delete($oldImage->path);
                    $oldImage->delete();
                }else{
                    $user->profile_image_id=$image->id;
                    $user->save();
                }
               
           }else{
               $user->save();
           }

            return redirect()->route('user.index',['userName'=>$userName]);
        }else{
            abort(403);
        }
    }
}
