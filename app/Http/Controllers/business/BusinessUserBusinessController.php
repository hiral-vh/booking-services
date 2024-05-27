<?php

namespace App\Http\Controllers\business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Services;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class BusinessUserBusinessController extends Controller
{
    public function rules () {
		return array_merge(
			[
                'name'     => 'required|max:255',
                'service'  => 'required',
			],
        );
	}
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index()
    {
        $this->data['business']=Business::getBusiness();
        $this->data['module']='Business '.'List ';
        $this->data['services']=Services::listServices();
        return view('business.businesses.index',$this->data);
    }

    public function create()
    {
        $this->data['module']='Business '.'Add ';
        $this->data['services']=Services::listServices();
        return view('business.businesses.create',$this->data);
    }

    public function store(Request $request)
    {
        $createBusiness=([
            "name"      =>$request->name,
            "service_id"=>$request->service,
            "created_at"=>now(),
            "created_by"=>Auth::guard('web')->user()->id,
            "created_by_user_type"=>2,
        ]);

        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect('business/create')->withErrors($validator,"admin")->withInput();
        }else{

            $business=Business::createBusiness($createBusiness);

            if($business)
            {
                Session::flash('success', 'Business '.trans('messages.createdSuccessfully'));
                return redirect('business-user');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-user');
            }
        }
    }

    public function show()
    {

    }
// UNUSED

    public function edit($id)
    {
        $this->data['module']='Business '.'Edit ';
        $this->data['services']=Services::listServices();
        $this->data['business']=Business::findBusiness($id);
        return view('business.businesses.edit',$this->data);
    }

    public function update(Request $request,$id)
    {
        $updateBusiness=([
            "name"=>$request->name,
            "service_id"=>$request->service,
            "updated_at"=>now(),
            "updated_by"=>Auth::guard('web')->user()->id,
            "updated_by_user_type"=>2,
        ]);

        $validator = Validator::make($request->all(),$this->rules($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $business=Business::updateBusiness($id,$updateBusiness);

            if($business)
            {
                Session::flash('success', 'Business '.trans('messages.updatedSuccessfully'));
                return redirect('business-user');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-user');
            }
        }
    }

    public function destroy($id)
    {

        $deleteArray=([
            "deleted_by"=>Auth::guard('web')->user()->id,
            "deleted_by_user_type"=>2,
        ]);

        Business::updateBusiness($id,$deleteArray);

        $business=Business::deleteBusiness($id);

        if($business)
            {
                Session::flash('success', 'Business '.trans('messages.deletedSuccessfully'));
                return redirect('business-user');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-user');
            }
    }

    public function updateBusinessStatus(Request $request)
    {
            $businessUpdateStatus = Business::findBusiness($request->id);
            $st = $businessUpdateStatus->status==1?0:1;
            $businessUpdateStatus->update(["status"=>$st]);
            return $st;
    }
}
