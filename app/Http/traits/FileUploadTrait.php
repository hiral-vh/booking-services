<?php

namespace App\Http\Traits;

class FileUploadTrait
{
	public static function image_upload($image, $path)
	{
		$name = uniqid() . time() . '.' . $image->getClientOriginalExtension();
		$destinationPath = public_path('/' . $path);
		$image->move($destinationPath, $name);
		return $path . '' . $name;
	}
}
