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

class BusinessVideoController extends Controller
{
  
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index()
    {
        $user=auth()->guard('business_user')->user();
        $this->data['module']='Video Details';
        $this->data['list'] = Video::getVideosByType();
      
        return view('business.business-video.index',$this->data);
    }

    public function viewDetails($id)
    {
        $this->data['module']='Video Details';
        $this->data['details'] = Video::findVideo($id);
        return view('business.business-video.show',$this->data);
    }
}
