<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuisine extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_cuisine';

    public static function getCuisine()
    {
        $query=Cuisine::orderBy('id','DESC')->paginate(10);
        return $query;
    }

    public static function getCuisineByName($name)
    {
        $query=Cuisine::where('cuisine_name','like','%'.$name.'%')->orderBy('id','DESC')->paginate(10);
        return $query;
    }

    public static function createCuisine($array)
    {
        $array['created_at']=now();
        $array['created_by']=Auth::guard('admin')->user()->id;
        $query=Cuisine::create($array);
        return $query;
    }

    public static function findCuisine($id)
    {
        $query=Cuisine::find($id);
        return $query;
    }

    public static function updateCuisine($id,$array)
    {
        $array['updated_at']=now();
        $array['updated_by']=Auth::guard('admin')->user()->id;
        $query=Cuisine::find($id)->update($array);
        return $query;
    }

    public static function deleteCuisine($id)
    {
        Cuisine::find($id)->update(['deleted_by'=>Auth::guard('admin')->user()->id]);
        $query=Cuisine::find($id)->delete();
        return $query;
    }
}
