<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'user_address';
    public $guarded=["id"];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    // public function user()
    // {
    //     return $this->hasOne(User::class,'id','user_id');
    // }

    public static function getUserAddress()
    {
        $query=UserAddress::with('user')->orderBy('id','desc')->paginate(10);
        return $query;
    }

    public static function getUserAddressById($id)
    {
        $query=UserAddress::with('user')->where('user_id',$id)->first();
        return $query;
    }

    // public static function getUserAddressByName($userName)
    // {
    //     $query=UserAddress::whereHas('user',function($q) use ($userName){
    //         $q->where('name', 'like', '%' .$userName . '%');
    //     })->paginate(10);
    //     return $query;
    // }

    public static function createUserAddress($array)
    {
        $query=UserAddress::create($array);
        return $query;
    }

    public static function updateUserAddress($id,$array)
    {
        $query=UserAddress::where('user_id',$id)->update($array);
        return $query;
    }

}
