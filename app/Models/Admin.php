<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    // use Authenticatable;

    public $timestamps = false;
    protected $table = 'admins';
    public $guarded = ["id"];

    public static function getAdmins()
    {
        $query = Admin::where('id', '!=', auth()->guard('admin')->id())->orderBy('id', 'DESC')->paginate(10);
        return $query;
    }

    public static function storeAdmin($array)
    {
        $query = Admin::create($array);
        return $query;
    }

    public static function findAdmin($id)
    {
        $query = Admin::find($id);
        return $query;
    }

    public static function checkEmail($email, $id)
    {
        $query = Admin::where("email", $email)->where('id', '<>', $id)->first();
        return $query;
    }

    public static function getUserByEmail($email, $id = "")
    {
        $query = Admin::select('*')->where('email', $email);
        if (!empty($id)) {
            $query->where('id', '!=', $id);
        }
        return $query->first();
    }

    public static function updateAdmin($id, $array)
    {
        $query = Admin::where("id",$id)->update($array);
        return $query;
    }

    public static function deleteAdmin($id)
    {
        $query = Admin::where("id", $id)->delete();
        return $query;
    }
    public static function updateAdminProfile($id, $array)
    {
        $query = Admin::where('id', $id)->update($array);
        return $query;
    }
    public static function updateAdminByEmail($email, $array)
    {
        $query = Admin::where('email', $email)->update($array);
        return $query;
    }
    public static function getByEmail($email)
    {
        $query = Admin::where('email', $email)->first();
        return $query;
    }
    public static function getByOTP($otp)
    {
        $query = Admin::where('otp', $otp)->first();
        return $query;
    }

    public static function getAdminByNameOrEmail($name='',$email='',$id)
    {
        $query = Admin::select('*');
        if (!empty($name)) {
            $query->where('name', 'like','%'.$name.'%');
        }
        if(!empty($email))
        {
            $query->where('email', 'like','%'.$email.'%');
        }
        return $query->where('id','!=',$id)->paginate(10);
    }
}
