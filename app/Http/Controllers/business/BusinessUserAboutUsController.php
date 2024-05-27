<?php

namespace App\Http\Controllers\business;


use App\Models\Business;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\ImageUploadTrait;
use App\Models\BusinessUser;
use Illuminate\Support\Facades\Validator;

class BusinessUserAboutUsController extends Controller
{
    use ImageUploadTrait;

    public function rules() {
		return array_merge(
			[
                'business'      => 'required|max:30',
                'email'         => 'required|email|max:100',
                'contact'       => 'required|numeric|max:9999999999',
                'address_line1' => 'required|max:100',
                'address_line2' => 'required|max:100',
                'city'          => 'required|max:100',
                'zip_code'      => 'required|numeric|max:999999',
                'about'         => 'required|max:500',
			],
        );
	}
    public function __construct(Request $request)
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index(Request $request)
    {
        $user=auth()->guard('business_user')->user();
        $this->data['businessAboutUs']=BusinessUser::findUser($user->id);
        $this->data['module']='About Business';
        return view('business.businesses-about-us.index',$this->data);
    }

    public function edit($id)
    {
        $this->data['module']='Business About Edit';
        $this->data['businessAboutUs']=BusinessUser::findUser($id);
        return view('business.businesses-about-us.edit',$this->data);
    }

    public function update(Request $request)
    {
        $user=Auth::guard('business_user')->user();
        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $updateBusinessAboutUs=([
                "name"=>$request->business,
                "email"=>$request->email,
                "contact"=>$request->contact,
                "address_line1"=>$request->address_line1,
                "address_line2"=>$request->address_line2,
                "city"=>$request->city,
                "zip_code"=>$request->zip_code,
                "about"=>$request->about,
                "updated_at"=>now(),
                "updated_by"=>Auth::guard('business_user')->user()->id,
            ]);

            $file_name = '';
            if ($request->hasFile('image')) {
                $file_name=$this->uploadImage($request->image,'business/images/business/');
            }

            if($file_name != ''){
                $updateBusinessAboutUs['business_image'] = $file_name;
            }
            $businessAboutUs=Business::updateBusiness($user->business_id,$updateBusinessAboutUs);

            if($businessAboutUs)
            {
                Session::flash('success', 'Business About Us '.trans('messages.updatedSuccessfully'));
                return redirect()->route('business-user-about-us.index');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->route('business-user-about-us.index');
            }
        }
    }

}
