<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'users';
    public $guarded = ["id"];

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'profile_photo_path',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'country_code',
        'status',
        'otp',
        'created_by_user_type',
        'updated_by_user_type',
        'deleted_by_user_type',
        'type',
        'business_id',
        'is_verify',
        'social_id',
        'social_type'
    ];

    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }

    protected $hidden = [
        // 'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function address()
    {
        return $this->hasOne(UserAddress::class, 'id', 'user_id');
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    public function businessAppointment()
    {
        return $this->belongsTo(BusinessAppointment::class, 'id', 'user_id');
    }
    public static function updateUserProfile($id, $array)
    {
        $query = User::where('id', $id)->update($array);
        return $query;
    }

    public static function getUsers()
    {
        $query = User::select('*')->get();
        return $query;
    }

    public static function getBusinessUsersWithPagination()
    {
        $query = User::with('business')->where('type', 2)->orderBy('id', 'desc')->paginate(10);
        return $query;
    }

    public static function findUser($id)
    {
        $query = User::find($id);
        return $query;
    }

    public static function updateUser($id, $array)
    {
        $query = User::where('id', $id)->update($array);
        return $query;
    }


    public static function deleteUser($id)
    {
        $query = User::find($id)->delete();
        return $query;
    }

    public static function getUsersWithPagination($id)
    {
        $query = User::whereHas('businessAppointment', function($q) use($id){
            $q->where('business_id',$id);})->paginate(10);
            
        return $query;
    }

    public static function createUser($array)
    {
        $query = User::create($array);
        return $query;
    }

    public static function getUsersByEmail($email)
    {
        $query = User::where('email', '=', $email)->first();
        return $query;
    }

    public static function updateUserByEmail($email, $array)
    {
        $query = User::where('email', '=', $email)->update($array);
        return $query;
    }

    public static function getUsersByValue($name='',$mobile='',$email='')
    {
        $query = User::select('*');
        if($name != '')
        {
            $query->where('name', 'LIKE', '%'.$name.'%');
        }
        if($mobile != '')
        {
            $query->where('mobile', 'LIKE', '%'.$mobile.'%');
        }
        if($email != '')
        {
            $query->where('email', 'LIKE', '%'.$email.'%');
        }
        return $query->paginate(10);
    }
    public static function getUserById($id)
    {
        $query = User::where('id', $id)->first();
        return $query;
    }
    public static function getUsersPagination()
    {
        $query = User::orderBy('id', 'desc')->paginate(10);
        return $query;
    }
}
