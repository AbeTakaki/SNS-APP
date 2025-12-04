<?php

namespace App\Http\Controllers\User\Edit;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\EditRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Models\Image;
use App\Services\ImageService;
use App\Services\UserService;
use Illuminate\Support\Facades\Storage;

class EditPutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        EditRequest $request,
        string $userName,
        UserService $userService,
        ImageService $imageService,
    ): RedirectResponse
    {
        $user = $userService->getUserByUserName($userName);
        if(Auth::user()->cannot('update', $user)) abort(403);
            
        $userService->setDisplayName($user->id, $request->getInput1());
        $userService->setProfile($user->id, $request->getInput2());
            
        if($request->getInput3()){
            $newImageId=$imageService->createImage($request->getInput3());

            if($user->profile_image_id){
                $oldImageId = $user->profile_image_id;
                $userService->setProfileImageId($user->id,$newImageId);
                $imageService->deleteImage($oldImageId);
            }else{
                $userService->setProfileImageId($user->id, $newImageId);
            }
        }
        
        return redirect()->route('user.index',['userName'=>$userName]);
    }
}
