<?php

namespace App\Http\Controllers\admin;

use Validator;
use App\Models\Business;
use App\Models\Services;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Models\BusinessAboutUs;
use App\Http\Controllers\Controller;
use App\Http\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BusinessAboutUsController extends Controller
{
    use ImageUploadTrait;

    public function rules () {
		return array_merge(
			[
                'business'    => 'required',
                'image'       => 'required|image',
                'location'    => 'required',
                'mobile'      => 'required',
                'description' => 'required',
			],
        );
	}
    public function rules1 () {
		return array_merge(
			[
                'business'    => 'required',
                'image'       => 'image',
                'location'    => 'required',
                'mobile'      => 'required',
                'description' => 'required',
			],
        );
	}
    public function __construct(Request $request)
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
        $this->data['business']=Business::findBusiness($request->business_id);
    }

    public function index(Request $request)
    {
        $this->data['businessAboutUs']=BusinessAboutUs::getBusinessAboutUs($request->business_id);
        $this->data['module']='About '.ucfirst($this->data['business']->name).' Details';
        return view('admin.business-about-us.index',$this->data);
    }

    public function create(Request $request)
    {
        $this->data['module']='About '.ucfirst($this->data['business']->name).' Add';
        return view('admin.business-about-us.create ',$this->data);
    }

    public function store(Request $request)
    {
        $createBusinessAboutUs=([
            "business_id" =>$request->business,
            "location"=>$request->location,
            "country_code"=>$request->country_code,
            "contact"=>$request->mobile,
            "description"=>$request->description,
            "created_at"=>now(),
            "created_by"=>Auth::guard('admin')->user()->id,
        ]);

        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect('business-about-us/create')->withErrors($validator,"admin")->withInput();
        }else{

            $file_name = '';
            if ($request->hasFile('image') ) {
                $file = $request->file('image');
                $file_name=$this->uploadImage($file,'assets/images/business/');
            }

            if($file_name != ''){
                $createBusinessAboutUs['image'] = $file_name;
            }

            $businessAboutUs=BusinessAboutUs::createBusinessAboutUs($createBusinessAboutUs);

            if($businessAboutUs)
            {
                Session::flash('success', 'Business About Us '.trans('messages.createdSuccessfully'));
                return redirect('business-about-us?business_id='.$request->business);
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-about-us?business_id='.$request->business);
            }
        }
    }


    public function edit($id)
    {
        $this->data['module']='About '.ucfirst($this->data['business']->name).' Edit';
        $this->data['businessAboutUs']=BusinessAboutUs::findBusinessAboutUs($id);
        return view('admin.business-about-us.edit',$this->data);
    }

    public function update(Request $request,$id)
    {

        $validator = Validator::make($request->all(),$this->rules1($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $updateBusinessAboutUs=([
                "business_id" =>$request->business,
                "location"=>$request->location,
                "country_code"=>$request->country_code,
                "contact"=>$request->mobile,
                "description"=>$request->description,
                "updated_at"=>now(),
                "updated_by"=>Auth::guard('admin')->user()->id,
            ]);

            $file_name = '';
            if ($request->hasFile('image') ) {
                $file = $request->file('image');
                $file_name=$this->uploadImage($file,'assets/images/business/');
            }

            if($file_name != ''){
                $updateBusinessAboutUs['image'] = $file_name;
            }

            $businessAboutUs=BusinessAboutUs::updateBusinessAboutUs($id,$updateBusinessAboutUs);


            if($businessAboutUs)
            {
                Session::flash('success', 'Business About Us '.trans('messages.updatedSuccessfully'));
                return redirect()->route('business-about-us.index',['business_id'=>$request->business]);
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business');
            }
        }
    }

    public function destroy(Request $request,$id)
    {
        $businessAboutUs= BusinessAboutUs::find($id)->delete();

        if($businessAboutUs)
            {
                Session::flash('success', 'Business About Us '.trans('messages.deletedSuccessfully'));
                return redirect('business-about-us?business_id='.$request->business);
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business/team-member/'.$request->business);
            }
    }

}
