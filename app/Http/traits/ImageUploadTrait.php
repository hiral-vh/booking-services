<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\URL;

trait ImageUploadTrait{
    public function uploadImage($file,$path){
        $imageName = time().'_'.rand(111,999).'.'.$file->getClientOriginalExtension();
        //$path = 'user_uploads/';
        $file->move(public_path($path),$imageName);
        return $path.$imageName;
    }

    public function uploadFullUrlImage($file,$path){
        $imageName = time().'_'.rand(111,999).'.'.$file->getClientOriginalExtension();
        //$path = 'user_uploads/';
        $file->move(public_path($path),$imageName);
        return URL::to('/').$path.$imageName;
    }

}
?>
