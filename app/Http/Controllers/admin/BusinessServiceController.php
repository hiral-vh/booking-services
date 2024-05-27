<?php

namespace App\Http\Controllers\admin;

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

class BusinessServiceController extends Controller
{
    public function rules()
    {
        return array_merge(
            [
                'name'   => 'required|string|max:255',
            ],
        );
    }
    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }

    public function BusinessServiceIndex($id)
    {
        $this->data['business'] = Business::findBusiness($id);
        $this->data['businessService'] = BusinessService::getBusinessServices($id);
        $this->data['module'] = ucfirst($this->data['business']->name) . ' Services List';
        return view('admin.business-service.index', $this->data);
    }

    public function BusinessServiceCreate($id)
    {
        $this->data['business'] = Business::findBusiness($id);
        $this->data['module'] = ucfirst($this->data['business']->name) . ' Services Add';
        return view('admin.business-service.create', $this->data);
    }

    public function BusinessServiceStore(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {
            $createService = ([
                "business_id" => $request->business_id,
                "name" => $request->name,
                "created_at" => now(),
                "created_by" => Auth::guard('admin')->user()->id,
                "created_by_user_type" => 1,
            ]);
            $service = BusinessService::createBusinessServices($createService);
            if ($service) {
                Session::flash('success', 'Business Service ' . trans('messages.createdSuccessfully'));
                return redirect('business/service/' . $request->business_id);
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business/service/' . $request->business_id);
            }
        }
    }

    public function BusinessServiceEdit($id)
    {
        $this->data['businessService'] = BusinessService::findBusinessServices($id);
        $this->data['module'] = ucfirst($this->data['businessService']->business->name) . ' Services Edit';
        return view('admin.business-service.edit', $this->data);
    }

    public function BusinessServiceUpdate(Request $request, $id)
    {
        $this->data['businessService'] = BusinessService::findBusinessServices($id);

        $updateService = ([
            "name" => $request->name,
            "updated_at" => now(),
            "updated_by" => Auth::guard('admin')->user()->id,
            "updated_by_user_type" => 1,
        ]);
        $validator = Validator::make($request->all(), $this->rules($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {

            $service = BusinessService::updateBusinessService($id, $updateService);

            if ($service) {
                Session::flash('success', 'Business Service ' . trans('messages.updatedSuccessfully'));
                return redirect('business/service/' . $request->business_id);
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business/service/' . $request->business_id);
            }
        }
    }

    public function BusinessServiceDelete(Request $request, $id)
    {
        $business = BusinessService::deleteBusinessService($id);

        $deleteArray = ([
            "deleted_by" => Auth::guard('admin')->user()->id,
            "deleted_by_user_type" => 1,
        ]);
        BusinessService::updateBusinessService($id, $deleteArray);

        if ($business) {
            Session::flash('success', 'Business Service ' . trans('messages.deletedSuccessfully'));
            return redirect('business/service/' . $request->business_id);
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('business/service/' . $request->business_id);
        }
    }

    public function updateBusinessServiceStatus(Request $request)
    {
        $businessServiceUpdateStatus = BusinessService::findBusinessServices($request->id);
        $st = $businessServiceUpdateStatus->status == 1 ? 0 : 1;
        $businessServiceUpdateStatus->update(["status" => $st]);
        return $st;
    }
}
