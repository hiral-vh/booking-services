<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ImageUploadTrait;
use Validator;

class SiteSettingController extends Controller
{
    use ImageUploadTrait;

    public function rules () {
		return array_merge(
			[
				'title'   =>  'required|max:255',
                'logo'    =>  'mimes:png',
                'favicon' =>  'mimes:ico',
			],
        );
	}

    public function index()
    {

        $data['sitesetting']=SiteSetting::getSiteSettings();
        $data['module']='Site Settings '.'Edit ';
        return view('admin.site-settings',$data);
    }
    public function update(Request $request)
    {
        $updateArray=([
                    "title"=>$request->title,
                    "updated_at"=>now(),
                    "updated_by"=>Auth::user()->id,
                ]);

        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,'admin')->withInput();
        }else{
           

            $file_name = '';
            if ($request->hasFile('logo') ) {
                $file_name=$this->uploadImage($request->logo,'/assets/images/');
            }

            if($file_name != ''){
                $updateArray['logo'] = $file_name;  
            }


            $file_name = '';
            if($request->hasFile('favicon'))
            {
                $file_name=$this->uploadImage($request->favicon,'/assets/images/');
            }

            if($file_name != ''){
                $updateArray['favicon'] = $file_name;
            }

            $update=SiteSetting::updateSiteSettings($updateArray);

            if ($update) {
                Session ::flash('success', 'Site Settings '.trans('messages.updatedSuccessfully'));
                return redirect()->back();
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }
    }
}
