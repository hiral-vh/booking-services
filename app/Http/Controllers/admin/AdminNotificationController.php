<?php

namespace App\Http\Controllers\admin;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function list()
    {
        $user=Auth::guard('admin')->user();
        $this->data['module']= "Notifications";
        $this->data['list']= Notification::adminNotification();
       
        return view('admin.admin-notification.index',$this->data);
    }
    public function markAsAdminReadNotificationById(Request $request)
    {
       
        $user=Auth::guard('admin')->user();
        $notification=Notification::updateNotification($request->notification_id,['is_read'=>1]);
        $getNotification=Notification::adminNotification();
        if(count($getNotification) > 0)
        {
            return response()->json(['status'=>1,'notification'=>$getNotification]);
        }else{
            return response()->json(['status'=>0]);
        }
    }
}

