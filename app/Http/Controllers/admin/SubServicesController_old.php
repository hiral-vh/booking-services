<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Http\Traits\FileUploadTrait;
use App\Models\BusinessService;
use App\Models\Services;
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
                'name' => 'required|max:255',
                'price' => 'required',
                'time' => 'required',
                'business_service_id' => 'required',
            ],
        );
    }
    public function rules1($id)
    {
        return array_merge(
            [
                'name'     => 'required|max:255',
                'price' => 'required',
                'time' => 'required',
                'business_service_id' => 'required',
            ],
        );
    }
    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }
    public function index()
    {
        $this->data['list'] = BusinessSubServices::getSubServices();
        $this->data['module'] = 'Sub-Services ' . 'List ';
        return view('admin.business-subservices.index', $this->data);
    }
    public function create()
    {
        $this->data['module'] = 'Sub-Services ' . 'Add ';
        $this->data['service'] = BusinessService::listServices();
        return view('admin.business-subservices.create', $this->data);
    }
    public function store(Request $request)
    {

        $createService = ([
            "name" => $request->name,
            "business_service_id" => $request->business_service_id,
            "time" => $request->time,
            "price" => $request->price,
            "created_at" => now(),
            "created_by" => Auth::guard('admin')->user()->id,
        ]);

        $validator = Validator::make($request->all(), $this->rules());


        if ($validator->fails()) {
            return redirect('sub-services/create')->withErrors($validator, "admin")->withInput();
        } else {

            $service = BusinessSubServices::create($createService);

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
        $this->data['service'] = BusinessService::listServices();
        $this->data['subService'] = BusinessSubServices::findSubServices($id);
        return view('admin.business-subservices.edit', $this->data);
    }
    public function update(Request $request, $id)
    {
        $updateService = ([
            "name" => $request->name,
            "business_service_id" => $request->business_service_id,
            "time" => $request->time,
            "price" => $request->price,
            "updated_at" => now(),
            "updated_by" => Auth::guard('admin')->user()->id,

        ]);

        $validator = Validator::make($request->all(), $this->rules1($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {
            $service = BusinessSubServices::updateSubServices($id, $updateService);

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
            "deleted_by" => Auth::guard('admin')->user()->id,
        ]);
        BusinessSubServices::updateSubServices($id, $deleteArray);

        $teamMember = BusinessSubServices::deleteSubServices($id);

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
        $teamMemberUpdateStatus = BusinessSubServices::findSubServices($request->id);
        $st = $teamMemberUpdateStatus->status == 1 ? 0 : 1;
        $teamMemberUpdateStatus->update(["status" => $st]);
        return $st;
    }
}
