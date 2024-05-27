<?php

namespace App\Models;

use App\Models\Userdeliveryaddress;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodUser extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'country_code',
        'mobile_no',
        'remember_token',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_user';

    public function address()
    {
        return $this->hasOne(Userdeliveryaddress::class,'user_id','id');
    }

    public static  function insert($data)
    {
        $Auth = auth()->user();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($Auth) {
            $data['created_by'] = $Auth['id'];
        }

        $insert = new FoodUser($data);
        $insert->save();
        $insertId = $insert->id;
        return $insertId;
    }
    public static function updateUser($id, $data)
    {
        $update = FoodUser::where('id', $id)->update($data);
        return $update;
    }
    public static function getAllUsers($firstName, $lastName, $email, $mobile)
    {
        $query = FoodUser::select('fs_user.first_name', 'fs_user.last_name', 'fs_user.email', 'fs_user.country_code', 'fs_user.mobile_no', 'fs_user.id');
        if ($firstName != "") {
            $query->where('fs_user.first_name', 'LIKE', '%' . $firstName . '%');
        }
        if ($lastName != "") {
            $query->where('fs_user.last_name', 'LIKE', '%' . $lastName . '%');
        }
        if ($email != "") {
            $query->where('fs_user.email', 'LIKE', '%' . $email . '%');
        }
        if ($mobile != "") {
            $query->where('fs_user.mobile_no', 'LIKE', '%' . $mobile . '%');
        }
        $query->orderBy('id', 'desc');

        return  $query->paginate(10);
    }
    public static function getUserById($id)
    {
        $query = FoodUser::where('id', $id)->first();
        return $query;
    }
}
