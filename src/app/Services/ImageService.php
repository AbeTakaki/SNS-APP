<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService {

    public function createImage(UploadedFile $file):int{
        $str=Storage::disk('public')->putFile('',$file);
        $image=new Image();
        $image->path=$str;
        $image->save();
        return $image->id;
    }

    public function deleteImage(int $id):void{
        $image=Image::where('id',$id)->firstOrFail();
        Storage::disk('public')->delete($image->path);
        $image->delete();
    }
}