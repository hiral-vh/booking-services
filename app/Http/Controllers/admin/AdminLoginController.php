<?php

namespace App\Http\Controllers\admin;

use Validator;
use App\Models\User;
use App\Models\Business;
use App\Models\FoodUser;
use App\Models\Services;
use App\Models\FoodOwner;
use App\Models\Ordermaster;
use App\Models\SiteSetting;
use App\Models\Foodcategory;
use Illuminate\Http\Request;
use App\Models\BusinessAppointment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

      protected $validationRules = [
        'email'    => 'required|email|unique:users,email',
        'password' => 'required',
    ];

    public function index()
    {
        if(Auth::guard('admin')->check())
        {
            $this->data['businessUsers'] = User::count();
            $this->data['businessOwners'] = Business::count();
            $this->data['appointments'] = BusinessAppointment::getTotalAppointment();
            $this->data['services'] = Services::count();
            $this->data['restaurantUsers'] = FoodUser::count();
            $this->data['orders'] = Ordermaster::count();
            $this->data['category'] = Foodcategory::count();
            $this->data['restaurantOwners'] = FoodOwner::count();
            $this->data['module'] = 'Dashboard';

            return view('dashboard',$this->data);
        }
        $this->data['module']='Admin Login';
        return view('auth.login',$this->data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator,'login')->withInput();
        }
        else
        {
            $credentials = $request->only('email', 'password');

            if (auth()->guard('admin')->attempt($credentials))
            {

                if($request->has('remember_me'))
                {
                    Cookie::queue('adminuser',$request->email,1440);
                    Cookie::queue('adminpwd',$request->password,1440);
                    //1440 for 24 hours.
                }
                Session::flash('success', 'Successfully logged in.');
                return redirect('dashboard');

            }else{
				Session::flash('error', 'Email Or Password Are Wrong.');
				return redirect()->back();
			}
        }

    }
    public function logout(Request $request)
	{
		Auth::guard('admin')->logout();
		return redirect('/admin-login');
	}
}
