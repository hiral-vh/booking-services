<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cms extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'cms';
    public $guarded=["id"];

    public static function getCms()
    {
        $query=Cms::orderBy('id','asc')->paginate(10);
        return $query;
    }
    // public static function getBusinessList()
    // {
    //     $query=Business::orderBy('name','asc')->get();
    //     return $query;
    // }

    public static function createCms($array)
    {
        $query=Cms::create($array);
        return $query;
    }

    public static function findCms($id)
    {
        $query=Cms::find($id);
        return $query;
    }

    public static function deleteCms($id)
    {
        $query=Cms::find($id)->delete();
        return $query;
    }

    public static function updateCms($id,$array)
    {
        $query=Cms::find($id)->update($array);
        return $query;
    }

}
