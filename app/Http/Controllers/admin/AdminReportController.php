<?php

namespace App\Http\Controllers\admin;

use App\Models\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessRecurringPaymentHistory;
use App\Models\FoodOwner;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function businessList(Request $request)
    {
        $user=Auth::guard('admin')->user();
        $this->data['module']= "Business Payment Report";
        $this->data['businessName'] = $businessName = $request->businessName;
        $this->data['userName'] = $userName = $request->userName;
        $this->data['planName'] = $planName = $request->planName;
        $this->data['list']= BusinessRecurringPaymentHistory::getPlans($businessName,$userName,$planName);
        return view('admin.payment_report.book',$this->data);
    }
    public function foodList(Request $request)
    {
        $user=Auth::guard('admin')->user();
        $this->data['module']= "E-Food Payment Report";
        $this->data['restaurantName'] = $restaurantName = $request->restaurantName;
        $this->data['ownerName'] = $ownerName = $request->ownerName;
        $this->data['planName'] = $planName = $request->planName;
        $this->data['list']= FoodOwner::getFoodAllPlans($restaurantName,$ownerName,$planName);

        return view('admin.payment_report.food',$this->data);
    }
}

