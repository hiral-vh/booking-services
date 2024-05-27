<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCardDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'user_card_detail';
    public $guarded=["id"];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public static function getUserCardDetails()
    {
        $query=UserCardDetails::with('user')->orderBy('id','desc')->paginate(10);
        return $query;
    }
    public static function getUserCardDetailsList($userId)
    {
        $query=UserCardDetails::where('user_id',$userId)->orderBy('id','DESC')->get();
        return $query;
    }
    public static function getUserCardDetailsById($id)
    {
        $query=UserCardDetails::with('user')->where('user_id',$id)->first();
        return $query;
    }

    public static function createUserCardDetails($array)
    {
        $query=UserCardDetails::create($array);
        return $query;
    }

    public static function updateUserCardDetails($id,$array)
    {
        $query=UserCardDetails::where('user_id',$id)->update($array);
        return $query;
    }

}
