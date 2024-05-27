<?php

namespace App\Http\Controllers\admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Models\Services;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;

class ServicesController extends Controller
{
    public function rules()
    {
        return array_merge(
            [
                'name'     => 'required|max:30',
                'image'    => 'required|mimes:jpeg,jpg,png,svg',
            ],
        );
    }
    public function rules1($id)
    {
        return array_merge(
            [
                'name'     => 'required|max:30',
                'image'    => 'mimes:jpeg,jpg,png,svg',
            ],
        );
    }
    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }

    public function index(Request $request)
    {
        $this->data['module'] = 'Services ' . 'List ';
        $this->data['servicesName'] = $servicesName = $request->servicesName;
        $this->data['service'] = Services::getServices($servicesName);
        return view('admin.services.index', $this->data);
    }

    public function create()
    {
        $this->data['module'] = 'Services ' . 'Add ';
        return view('admin.services.create', $this->data);
    }

    public function store(Request $request)
    {
        $createService = ([
            "name" => $request->name,
            "created_at" => now(),
            "created_by" => Auth::guard('admin')->user()->id,
            "created_by_user_type" => 1,
        ]);

        $validator = Validator::make($request->all(), $this->rules());

        // echo"<pre/>";print_r($validator);die;
        if ($validator->fails()) {
            return redirect('services/create')->withErrors($validator, "admin")->withInput();
        } else {

            $file_name = '';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = FileUploadTrait::image_upload($file, 'assets/images/services/');
            }

            if ($file_name != '') {
                $createService['image'] = $file_name;
            }

            $service = Services::createServices($createService);

            if ($service) {
                Session::flash('success', 'Service ' . trans('messages.createdSuccessfully'));
                return redirect('services');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('services');
            }
        }
    }

    public function show(Admin $admin)
    {
    }


    public function edit($id)
    {
        $this->data['module'] = 'Services ' . 'Edit ';
        $this->data['service'] = Services::findServices($id);
        return view('admin.services.edit', $this->data);
    }

    public function update(Request $request, $id)
    {
        $updateService = ([
            "name" => $request->name,
            "updated_at" => now(),
            "updated_by" => Auth::guard('admin')->user()->id,
            "updated_by_user_type" => 1,
        ]);

        $validator = Validator::make($request->all(), $this->rules1($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {

            $file_name = '';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = FileUploadTrait::image_upload($file, 'assets/images/services/');
            }

            if ($file_name != '') {
                $updateService['image'] = $file_name;
            }

            $service = Services::updateServices($id, $updateService);

            if ($service) {
                Session::flash('success', 'Service ' . trans('messages.updatedSuccessfully'));
                return redirect()->route('services.index');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }
    }

    public function destroy($id)
    {
        $service = Services::deleteService($id);

        if (isset($service)) {
            Session::flash('success', 'Business Service ' . trans('messages.deletedSuccessfully'));
            return redirect()->route('services.index');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect()->back();
        }
    }

}
