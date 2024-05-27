<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodOwner extends Authenticatable
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_owner';

    public static  function insert($data)
    {
        $Auth = auth()->user();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($Auth) {
            $data['created_by'] = $Auth['id'];
        }

        $insert = new FoodOwner($data);
        $insert->save();
        $insertId = $insert->id;
        return $insertId;
    }
    public static function getAllOwners($restaurantName, $ownerName, $email, $mobile)
    {
        $query = FoodOwner::select('fs_owner.restaurant_name', 'fs_owner.owner_name', 'fs_owner.email', 'fs_owner.country_code', 'fs_owner.phone_no');
        if ($restaurantName != "") {
            $query->where('fs_owner.restaurant_name', 'LIKE', '%' . $restaurantName . '%');
        }
        if ($ownerName != "") {
            $query->where('fs_owner.owner_name', 'LIKE', '%' . $ownerName . '%');
        }
        if ($email != "") {
            $query->where('fs_owner.email', 'LIKE', '%' . $email . '%');
        }
        if ($mobile != "") {
            $query->where('fs_owner.phone_no', 'LIKE', '%' . $mobile . '%');
        }
        $query->orderBy('id', 'desc');

        return $query->paginate(10);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'plan_id', 'id');
    }


    public static function getFoodAllPlans($restaurantName,$ownerName,$planName)
    {
        $query = FoodOwner::select('fs_owner.id','fs_owner.restaurant_name','fs_owner.owner_name','fs_owner.updated_at','fs_owner.plan_id')->with('subscription');
        if ($planName != "") {
            $query->whereHas('subscription', function ($q) use ($planName) {
                $q->where('plan_name', 'like', '%' . $planName . '%');
            });
        }
        if ($restaurantName != "") {
            $query->where('fs_owner.restaurant_name', 'LIKE', '%' . $restaurantName . '%');
        } 
        if ($ownerName != "") {
            $query->where('fs_owner.owner_name', 'LIKE', '%' . $ownerName . '%');
        }
        $query->where('fs_owner.plan_id','!=',1);
        return $query->paginate(10);
    }
}
