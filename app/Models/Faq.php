<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'faq';
    public $guarded=["id"];

    public static function getFaq()
    {
        $query=Faq::orderBy('id','desc')->paginate(10);
        return $query;
    }
    public static function getAllFaq()
    {
        $query=Faq::orderBy('id','desc')->get();
        return $query;
    }

    public static function createFaq($array)
    {
        $query=Faq::create($array);
        return $query;
    }

    public static function findFaq($id)
    {
        $query=Faq::find($id);
        return $query;
    }

    public static function deleteFaq($id)
    {
        $query=Faq::find($id)->delete();
        return $query;
    }

    public static function updateFaq($id,$array)
    {
        $query=Faq::find($id)->update($array);
        return $query;
    }

}
