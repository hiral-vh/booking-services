<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ordermaster extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_order_master';

    public function user()
    {
        return $this->belongsTo(FoodUser::class, 'user_id', 'id');
    }

    public function restaurant()
    {
        return $this->belongsTo(FoodOwner::class, 'restaurant_id', 'id');
    }

    public function deliveryPerson()
    {
        return $this->belongsTo(Deliveryperson::class, 'delivery_id', 'id');
    }

    public function userBookTable()
    {
        return $this->belongsTo(Userbooktable::class, 'book_table_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(Orderitemmaster::class, 'order_id', 'id');
    }

    public static function findOrder($id)
    {
        $query=Ordermaster::with(['user','restaurant','deliveryPerson','userBookTable','orderItems'])->find($id);
        return $query;
    }

    public static function getOrder()
    {
        $query=Ordermaster::with('user')->get();
        return $query;
    }
    public static function getOrderBySearchValue($name,$orderType,$orderNumber,$orderStatus,$deliveryCharge,$totalAmount)
    {
        $query=Ordermaster::with('user');
        if ($name != "") {
            $query->whereHas('user', function ($q) use ($name) {
                $q->where('first_name', 'like', '%' . $name . '%')->orWhere('last_name','like','%'.$name.'%');
            });
        }

        if ($orderType != "") {
            $query->where('order_type',$orderType);
        }

        if ($orderNumber != "") {
            $query->where('order_number',$orderNumber);
        }

        if ($orderStatus != "") {
            $query->where('order_status',$orderStatus);
        }

        if ($deliveryCharge != "") {
            $query->where('delivery_charge',$deliveryCharge);
        }

        if ($totalAmount != "") {
            $query->where('total_amount',$totalAmount);
        }

        return $query->paginate(10);
    }

    public static function totalOrderOfUser($userId)
    {
        $query=Ordermaster::where('user_id',$userId)->where('order_status','Delivered')->count();
        return $query;
    }

    public static function totalAmountByUser($userId)
    {
        $query=Ordermaster::where('user_id',$userId)->where('order_status','Delivered')->sum('total_amount');
        return $query;
    }

    public static function totalDeliveredOrderByUser($userId)
    {
        $query=Ordermaster::where('user_id',$userId)->where('order_status','Delivered')->count();
        return $query;
    }

}
