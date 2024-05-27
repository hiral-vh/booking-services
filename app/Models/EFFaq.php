<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class EFFaq extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_faq';

    public static function getFaq()
    {
        $query=EFFaq::orderBy('id','desc')->paginate(10);
        return $query;
    }

    public static function getAllFaq()
    {
        $query=EFFaq::all();
        return $query;
    }

    public static function createFaq($array)
    {
        $array['created_at']=now();
        $array['created_by']=Auth::guard('admin')->user()->id;
        $query=EFFaq::create($array);
        return $query;
    }

    public static function findFaq($id)
    {
        $query=EFFaq::find($id);
        return $query;
    }

    public static function deleteFaq($id)
    {
        EFFaq::find($id)->update(['deleted_by'=>Auth::guard('admin')->user()->id]);
        $query=EFFaq::find($id)->delete();
        return $query;
    }

    public static function updateFaq($id,$array)
    {
        $array['updated_at']=now();
        $array['updated_by']=Auth::guard('admin')->user()->id;
        $query=EFFaq::find($id)->update($array);
        return $query;
    }
}
