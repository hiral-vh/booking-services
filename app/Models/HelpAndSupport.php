<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpAndSupport extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'help_and_support';
    public $guarded=["id"];

    public static function getHelpAndSupport()
    {
        $query=HelpAndSupport::orderBy('id','desc')->paginate(10);
        return $query;
    }

    public static function createHelpAndSupport($array)
    {
        $query=HelpAndSupport::create($array);
        return $query;
    }

    public static function findHelpAndSupport($id)
    {
        $query=HelpAndSupport::find($id);
        return $query;
    }

    // public static function deleteFaq($id)
    // {
    //     $query=Faq::find($id)->delete();
    //     return $query;
    // }

    // public static function updateFaq($id,$array)
    // {
    //     $query=Faq::find($id)->update($array);
    //     return $query;
    // }

}
