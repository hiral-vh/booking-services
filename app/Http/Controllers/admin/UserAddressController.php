<?php

namespace App\Http\Controllers\admin;

use App\Models\SiteSetting;
use App\Models\UserAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class UserAddressController extends Controller
{
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index(Request $request)
    {
        if(!empty($request->userName))
        {
            $this->data['userAddress']=UserAddress::getUserAddressByName($request->userName);
        }
        else{
            $this->data['userAddress']=UserAddress::getUserAddress();
        }

        return view('admin.user-address.index',$this->data);
    }

}
