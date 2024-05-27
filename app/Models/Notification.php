<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'notification';
    public $guarded=["id"];

    public static function getNotification()
    {
        $query=Notification::orderBy('id','desc')->paginate(10);
        return $query;
    }
    public static function getNotificationList($userId)
    {
        $query=Notification::where('receiver_id',$userId)->orderBy('id','desc')->get();
        return $query;
    }

    public static function getNotificationListByBusinessId($businessId)
    {
        $query=Notification::where('receiver_id',$businessId)->where('is_read',null)->orderBy('id','DESC')->get();
        return $query;
    }
    public static function getWebNotifyNotification($businessId)
    {
        $query =  Notification::where('receiver_id',$businessId)->where('web_notify','0')->orderBy('id','DESC')->first();
        return $query;
    }

    public static function createNotification($array)
    {
        $user=Auth::user();
        $array['created_at']=now();
        $query=Notification::create($array);
        return $query;
    }

    public static function findNotification($id)
    {
        $query=Notification::find($id);
        return $query;
    }

    public static function deleteNotification($id)
    {
        $query=Notification::find($id)->delete();
        return $query;
    }

    public static function updateNotification($id,$array)
    {
        $query=Notification::find($id)->update($array);
        return $query;
    }

    public static function adminNotification()
    {
        $query = Notification::where('notification_type',7)->where('is_read',null)->orderBy('id','DESC')->get();
        return $query;
    }

}
