<?php

namespace App\Http\Controllers\business;

use Validator;
use App\Models\Business;
use App\Models\Services;
use App\Models\SiteSetting;
use App\Models\Subcription;
use Illuminate\Http\Request;
use App\Models\BusinessService;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class BusinessSubscriptionController extends Controller
{
  
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index()
    {
        $user=auth()->guard('business_user')->user();
        $this->data['module']='Subscription Details';
        $this->data['list'] = Subcription::getSubscription($user->business_id);

        return view('business.subscription.index',$this->data);
    }

 
}
