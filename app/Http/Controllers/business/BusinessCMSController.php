<?php

namespace App\Http\Controllers\business;

use Validator;
use App\Models\Business;
use App\Models\Services;
use App\Models\SiteSetting;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Models\BusinessService;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class BusinessCMSController extends Controller
{
  
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index()
    {
        $this->data['module']='Privacy Policy';
        return view('business.privacy-policy',$this->data);
    }
    public function list()
    {
        $this->data['module']='Cookies';
        return view('business.cookies',$this->data);
    }
    public function terms()
    {
        $this->data['module']='Terms & Conditions';
        return view('business.terms',$this->data);
    }
}
