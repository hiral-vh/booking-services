<?php

namespace App\Http\Controllers\admin;

use App\Models\Admin;
use App\Models\User;
use App\Models\Business;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AppointmentPayment;
use App\Models\BusinessAppointment;
use App\Models\BusinessPayment;
use App\Models\BusinessUser;
use App\Models\Foodcategory;
use App\Models\Foodmenucategory;
use App\Models\FoodOwner;
use App\Models\FoodUser;
use App\Models\Ordermaster;
use App\Models\SiteSetting;
use App\Notifications\UserBookingNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;

class DashboardController extends Controller
{

    public function __construct()
    {
    }
    public function index()
    {
        $data['businessUsers'] = User::count();
        $data['subscribedUsers'] = Business::getTotalSubscribedBusiness()->count();
        $data['totalSales'] = AppointmentPayment::getTotalPayments();
        $data['services'] = Services::count();
        $data['restaurantUsers'] = FoodUser::count();
        $data['orders'] = Ordermaster::count();
        $data['category'] = Foodcategory::count();
        $data['restaurantOwners'] = FoodOwner::count();
        $data['module'] = 'Dashboard';
        return view('dashboard', $data);
    }


}
