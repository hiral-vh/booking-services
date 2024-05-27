<?php

namespace App\Http\Controllers\business;

use Validator;
use App\Models\Business;
use App\Models\Services;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Models\BusinessService;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class BusinessUserServiceController extends Controller
{
    public function rules () {
		return array_merge(
			[
                'name'   => 'required|string|max:255',
			],
        );
	}
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index()
    {
        $user=auth()->guard('business_user')->user();
        $this->data['businessService']=BusinessService::getBusinessServices($user->id);
        $this->data['module']=ucfirst($this->data['businessService'][0]->business->name).' Services List';
        return view('business.businesses-services.index',$this->data);
    }

    public function create()
    {
        $user=auth()->guard('business_user')->user();
        $this->data['businessService']=BusinessService::getBusinessServices($user->id);
        $this->data['module']=ucfirst($this->data['businessService'][0]->business->name).' Services Add';
        return view('business.businesses-services.create',$this->data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{
            $createService=([
                "business_id"=>$request->business_id,
                "name"=>$request->name,
                "created_at"=>now(),
                "created_by"=>Auth::guard('business_user')->user()->id,
                "created_by_user_type"=>2,
            ]);
            $service=BusinessService::createBusinessServices($createService);
            if($service)
            {
                Session::flash('success', 'Business Service '.trans('messages.createdSuccessfully'));
                return redirect('business-user-business-services');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-user-business-services');
            }
        }
    }

    public function edit($id)
    {
        $user=auth()->guard('business_user')->user();
        $this->data['businessService']=BusinessService::findBusinessServices($id);
        $this->data['module']=ucfirst($this->data['businessService']->business->name).' Services Edit';
        return view('business.businesses-services.edit',$this->data);
    }

    public function update(Request $request,$id)
    {
        $this->data['businessService']=BusinessService::findBusinessServices($id);

        $updateService=([
                    "name"=>$request->name,
                    "updated_at"=>now(),
                    "updated_by"=>Auth::guard('business_user')->user()->id,
                    "updated_by_user_type"=>2,
                ]);
                $validator = Validator::make($request->all(),$this->rules($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $service=BusinessService::updateBusinessService($id,$updateService);

                    if($service)
                    {
                        Session::flash('success', 'Business Service '.trans('messages.updatedSuccessfully'));
                        return redirect('business-user-business-services');
                    } else {
                        Session::flash('error', trans('messages.errormsg'));
                        return redirect('business-user-business-services');
                    }
        }

    }

    public function destroy(Request $request,$id)
    {
        $deleteArray=([
            "deleted_by"=>Auth::guard('business_user')->user()->id,
            "deleted_by_user_type"=>2,
            "status"=>0,
        ]);

        BusinessService::updateBusinessService($id,$deleteArray);

        $business=BusinessService::deleteBusinessService($id);

        if($business)
        {
            Session::flash('success', 'Business Service '.trans('messages.deletedSuccessfully'));
            return redirect('business-user-business-services');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('business-user-business-services');
        }
    }

    public function updateBusinessServiceStatus(Request $request)
    {
            $businessServiceUpdateStatus = BusinessService::findBusinessServices($request->id);
            $st = $businessServiceUpdateStatus->status==1?0:1;
            $businessServiceUpdateStatus->update(["status"=>$st]);
            return $st;
    }
}
