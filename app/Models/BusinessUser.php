<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BusinessUser extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    // use Authenticatable;

    public $timestamps=false;
    protected $table = 'business_users';
    public $guarded=["id"];

    public function business()
    {
        return $this->belongsTo(Business::class,'business_id','id');
    }

    public static function getBusinessUsersWithPagination()
    {
        $query = BusinessUser::with('business')->orderBy('id','desc')->paginate(10);
        return $query;
    }
    public static function createBusinessUser($array)
    {
        $query=BusinessUser::create($array);
        return $query;
    }

    public static function getUserByEmail($email,$id = "")
    {
        $query = BusinessUser::select('*')->where('email',$email);
        if(!empty($id)){
          $query->where('id','!=',$id);
        }
        return $query->first();
    }
    public static function getUsersByName($name)
    {
        $query = BusinessUser::with('business')->where('name','LIKE','%'.$name.'%')->paginate(10);
        return $query;
    }
    public static function updateUser($id,$array)
    {
        $query = BusinessUser::find($id)->update($array);
        return $query;
    }
    public static function updateUserByEmail($email,$array)
    {
        $query = BusinessUser::where('email',$email)->update($array);
        return $query;
    }
    public static function findUser($id)
    {
        $query = BusinessUser::with('business')->where('id',$id)->first();
        return $query;
    }
    public static function findUserByEmailAndToken($email,$token)
    {
        $query = BusinessUser::where('email',$email)->where('remember_token',$token)->first();
        return $query;
    }
}
