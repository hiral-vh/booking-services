<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HelpAndSupport;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class HelpAndSupportController extends Controller
{
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index()
    {
        $this->data['module']='Help & Support '.'List ';
        $this->data['has']=HelpAndSupport::getHelpAndSupport();
        return view('admin.help-and-support.index',$this->data);
    }

    public function updateHasStatus(Request $request)
    {
            $hasUpdateStatus = HelpAndSupport::findHelpAndSupport($request->id);
            $st = $hasUpdateStatus->status==1?0:1;
            $hasUpdateStatus->update(["status"=>$st]);
            return $st;
    }
}
