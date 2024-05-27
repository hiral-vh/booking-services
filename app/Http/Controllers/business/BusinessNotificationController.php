<?php

namespace App\Http\Controllers\business;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BusinessNotificationController extends Controller
{
    public function list()
    {
        $user=Auth::guard('business_user')->user();
        $this->data['module']="Notifications";
        $this->data['businessNotification']=Notification::getNotificationListByBusinessId($user->business_id);
        return view('business.business-notification.index',$this->data);
    }
}
