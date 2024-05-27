<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Http\Traits\FileUploadTrait;
use App\Models\BusinessService;
use App\Models\Services;
use App\Models\SubService;
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
        $this->data['list'] = SubService::getSubServices($servicesName, $subServicesName);
        $this->data['module'] = 'Sub-Services ' . 'List ';
        return view('admin.sub-services.index', $this->data);
    }
    public function create()
    {
        $this->data['module'] = 'Sub-Services ' . 'Add ';
        $this->data['service'] = Services::listServices();
        return view('admin.sub-services.create', $this->data);
    }
    public function store(Request $request)
    {

        $createService = ([
            "name" => $request->name,
            "service_id" => $request->service_id,
            "created_at" => now(),
            "created_by" => Auth::guard('admin')->user()->id,
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
        $this->data['service'] = Services::listServices();
        $this->data['subService'] = SubService::findSubServices($id);
        return view('admin.sub-services.edit', $this->data);
    }
    public function update(Request $request, $id)
    {
        $updateService = ([
            "name" => $request->name,
            "service_id" => $request->service_id,
            "updated_at" => now(),
            "updated_by" => Auth::guard('admin')->user()->id,

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
            "deleted_by" => Auth::guard('admin')->user()->id,
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
