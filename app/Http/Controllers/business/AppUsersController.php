<?php

namespace App\Http\Controllers\business;

use App\Models\User;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Models\BusinessAppointment;
use App\Http\Controllers\Controller;
use Auth;

class AppUsersController extends Controller
{
    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }

    public function index(Request $request)
    {
        $this->data['module'] = 'App Users List';
        $this->data['name']=$request->name;
        $this->data['mobile']=$request->mobile;
        $this->data['email']=$request->email;

        $user = Auth::guard('business_user')->user();
     
        if (!empty($request->name)) {
            $this->data['appUsers'] = User::getUsersByValue($request->name,'','');
        }
        if(!empty($request->mobile)){
            $this->data['appUsers'] = User::getUsersByValue('',$request->mobile,'');
        }
        if(!empty($request->email)){
            $this->data['appUsers'] = User::getUsersByValue('','',$request->email);
        }
        if(empty($request->name) && empty($request->mobile) && empty($request->email))
        {
            $this->data['appUsers'] = User::getUsersWithPagination($user->business_id);
        }
        
    
        return view('business.app-users.index', $this->data);
    }

    public function show($id)
    {
        $this->data['appUsers'] = User::getUserById($id);
        $this->data['module'] = 'App Users Show';
        $this->data['appointment']=BusinessAppointment::getTotalAppointmentOfUser($id);
        $this->data['cancelAppointment']=BusinessAppointment::getCancelAppointmentOfUser($id);
        return view('business.app-users.show', $this->data);
    }
}
