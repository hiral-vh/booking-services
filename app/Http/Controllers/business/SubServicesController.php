<?php

namespace App\Http\Controllers\business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Http\Traits\FileUploadTrait;
use App\Models\BusinessService;
use App\Models\Services;
use App\Models\SubService;
use App\Models\Business;
use App\Models\BusinessSubServices;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;

class SubServicesController extends Controller
{
    public function rules()
    {
        return array_merge(
            [
                'name' => 'required|max:30',
                'service_id' => 'required',
            ],
        );
    }
    public function rules1($id)
    {
        return array_merge(
            [
                'name'     => 'required|max:30',
                'service_id' => 'required',
            ],
        );
    }
    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }
    public function index(Request $request)
    {
       
        $this->data['servicesName'] = $servicesName = $request->servicesName;
        $this->data['subServicesName'] = $subServicesName = $request->subServicesName;
        $business_id = Auth::guard('business_user')->user()->business_id;
        $businessServiceId = Business::findBusiness($business_id)->service_id;
        $this->data['list'] = SubService::getSubServices($servicesName, $subServicesName,$businessServiceId,$business_id);
        $this->data['module'] = 'Sub-Services ' . 'List ';
        return view('business.sub-services.index', $this->data);
    }
    public function create()
    {
        $this->data['module'] = 'Sub-Services ' . 'Add ';
        $business_id = Auth::guard('business_user')->user()->business_id;
        $businessServiceId = Business::findBusiness($business_id)->service_id;
        $this->data['service'] = Services::findServices($businessServiceId);
        
        return view('business.sub-services.create', $this->data);
    }
    public function store(Request $request)
    {

        $createService = ([
            "name" => $request->name,
            "service_id" => $request->service_id,
            "created_at" => now(),
            "created_by" => Auth::guard('business_user')->user()->id,
        ]);

        $validator = Validator::make($request->all(), $this->rules());


        if ($validator->fails()) {
            return redirect('sub-services/create')->withErrors($validator, "admin")->withInput();
        } else {

            $service = SubService::create($createService);

            if ($service) {
                Session::flash('success', 'Sub-Service ' . trans('messages.createdSuccessfully'));
                return redirect('sub-services');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('sub-services');
            }
        }
    }
    public function edit($id)
    {
        $this->data['module'] = 'Sub-Services ' . 'Edit ';
        $business_id = Auth::guard('business_user')->user()->business_id;
        $businessServiceId = Business::findBusiness($business_id)->service_id;
        $this->data['service'] = Services::findServices($businessServiceId);
        $this->data['subService'] = SubService::findSubServices($id);
        return view('business.sub-services.edit', $this->data);
    }
    public function update(Request $request, $id)
    {
        $updateService = ([
            "name" => $request->name,
            "service_id" => $request->service_id,
            "updated_at" => now(),
            "updated_by" => Auth::guard('business_user')->user()->id,

        ]);

        $validator = Validator::make($request->all(), $this->rules1($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {
            $service = SubService::updateSubServices($id, $updateService);

            if ($service) {
                Session::flash('success', 'Service ' . trans('messages.updatedSuccessfully'));
                return redirect('sub-services');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('sub-services');
            }
        }
    }
    public function destroy($id)
    {
        $deleteArray = ([
            "deleted_by" => Auth::guard('business_user')->user()->id,
        ]);
        SubService::updateSubServices($id, $deleteArray);

        $teamMember = SubService::deleteSubServices($id);

        if ($teamMember) {
            Session::flash('success', 'Business Sub Services ' . trans('messages.deletedSuccessfully'));
            return redirect('sub-services');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('sub-services');
        }
    }
    public function updateSubServiceStatus(Request $request)
    {
        $teamMemberUpdateStatus = SubService::findSubServices($request->id);
        $st = $teamMemberUpdateStatus->status == 1 ? 0 : 1;
        $teamMemberUpdateStatus->update(["status" => $st]);
        return $st;
    }
}
