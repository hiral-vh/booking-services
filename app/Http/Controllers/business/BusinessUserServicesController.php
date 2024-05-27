<?php

namespace App\Http\Controllers\business;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Models\Services;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class BusinessUserServicesController extends Controller
{
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function rules () {
		return array_merge(
			[
                'name'     => 'required|max:255',
                'image'    => 'required|mimes:jpeg,jpg,png,svg',
			],
        );
	}
    public function rules1 () {
		return array_merge(
			[
                'name'     => 'required|max:255',
                'image'    => 'mimes:jpeg,jpg,png,svg',
			],
        );
	}

    public function index()
    {
        $this->data['module']='Services '.'List ';
        $this->data['service']=Services::getServices();
        return view('business.services.index',$this->data);
    }

    public function create()
    {
        $this->data['module']='Services '.'Add ';
        return view('business.services.create',$this->data);
    }

    public function store(Request $request)
    {
        $createService=([
            "name"=>$request->name,
            "created_at"=>now(),
            "created_by"=>Auth::guard('web')->user()->id,
            "created_by_user_type"=>2,
        ]);

        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect('business-user-services/create')->withErrors($validator,"admin")->withInput();
        }else{

            $file_name = '';
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $file_name = FileUploadTrait::image_upload($file,'assets/images/services/');
                }

                if($file_name != ''){
                    $createService['image'] = $file_name;
                }

             $service=Services::createServices($createService);

            if($service)
            {
                Session::flash('success', 'Service '.trans('messages.createdSuccessfully'));
                return redirect('business-user-services');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-user-services');
            }
        }
    }

    public function show(Admin $admin)
    {

    }


    public function edit($id)
    {
        $this->data['module']='Services '.'Edit ';
        $this->data['service']=Services::findServices($id);
        return view('business.services.edit',$this->data);
    }

    public function update(Request $request,$id)
    {

        $updateService=([
            "name"=>$request->name,
            "updated_at"=>now(),
            "updated_by"=>Auth::guard('web')->user()->id,
            "updated_by_user_type"=>2,
        ]);

        $validator = Validator::make($request->all(),$this->rules1($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $file_name = '';
            if ($request->hasFile('image') ) {
                $file = $request->file('image');
                $file_name = FileUploadTrait::image_upload($file,'assets/images/services/');
            }

            if($file_name != ''){
                $updateService['image'] = $file_name;
            }

            $service=Services::updateServices($id,$updateService);

            if($service)
            {
                Session::flash('success', 'Service '.trans('messages.updatedSuccessfully'));
                return redirect('business-user-services');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-user-services');
            }
        }
    }

    public function updateServiceStatus(Request $request)
    {
            $serviceUpdateStatus = Services::findServices($request->id);
            $st = $serviceUpdateStatus->status==1?0:1;
            $serviceUpdateStatus->update(["status"=>$st]);
            return $st;
    }

}
