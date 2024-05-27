<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $timestamps=false;
    protected $table = 'subscription_master';
    public $guarded=["id"];

    public static function getSubscription()
    {
        $query=Subscription::orderBy('id','DESC')->paginate(10);
        return $query;
    }

    public static function getSubscriptionByType($type)
    {
        $query=Subscription::where('type',$type)->orderBy('id','DESC')->paginate(10);
        return $query;
    }

    public static function createSubscription($array)
    {
        $array['created_at']=now();
        $array['created_by']=Auth::guard('admin')->user()->id;
        $query=Subscription::create($array);
        return $query;
    }

    public static function findSubscription($id)
    {
        $query=Subscription::find($id);
        return $query;
    }

    public static function updateSubscription($id,$array)
    {
        $array['updated_at']=now();
        $array['updated_by']=Auth::guard('admin')->user()->id;
        $query=Subscription::find($id)->update($array);
        return $query;
    }

    public static function deleteSubscription($id)
    {
        Subscription::find($id)->update(["deleted_by"=>Auth::guard('admin')->user()->id]);
        $query=Subscription::find($id)->delete();
        return $query;
    }
}
