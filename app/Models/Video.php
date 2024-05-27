<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $timestamps=false;
    protected $table = 'video_master';
    public $guarded=["id"];

    public static function createVideo($array)
    {
        $array['created_at']=now();
        $array['created_by']=Auth::guard('admin')->user()->id;
        $query=Video::create($array);
        return $query;
    }
    public static function findVideo($id)
    {
        $query=Video::find($id);
        return $query;
    }
    public static function updateVideo($id,$array)
    {
        $array['updated_at']=now();
        $array['updated_by']=Auth::guard('admin')->user()->id;
        $query=Video::find($id)->update($array);
        return $query;
    }
    public static function getVideoByType($type)
    {
        $query=Video::where('type',$type)->orderBy('id','DESC')->paginate(10);
        return $query;
    }
    public static function deleteVideo($id)
    {
        Video::find($id)->update(["deleted_by"=>Auth::guard('admin')->user()->id]);
        $query=Video::find($id)->delete();
        return $query;
    }
    public static function getVideosByType()
    {
        $query = Video::where('type','business')->get();
        return $query;
    }
   
}
