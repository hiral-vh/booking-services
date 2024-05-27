<?php

namespace App\Http\Controllers\business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\SiteSetting;
use App\Models\BusinessService;
use App\Models\Services;
use App\Models\BusinessSubServices;
use App\Models\SubService;
use App\Models\TeamMembers;
use App\Models\ProductWiseTeamMember;
use App\Http\Traits\FileUploadTrait;
use App\Models\BusinessTeamMember;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;

class BusinessUserSubServicesController extends Controller
{
    public function rules()
    {
        return array_merge(
            [
                'business_service_id' => 'required',
                'name'                => 'required|max:30',
                'time'                => 'required',
                'image'               => 'required|mimes:jpg,jpeg,png,bmp,svg',
            ],
        );
    }
    public function rules1($id)
    {
        return array_merge(
            [
                'business_service_id' => 'required',
                'name'                => 'required|max:30',
                'time'                => 'required',
                'image'               => 'mimes:jpg,jpeg,png,bmp,svg',
            ],
        );
    }
    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }
    public function index(Request $request)
    {
        $this->data['requestSubService']=$request->sub_service;
        $this->data['requestName']=$request->name;
        $this->data['requestPrice']=$request->price;
        $this->data['requestTime']=$request->time;
        $user=Auth::guard('business_user')->user();
        $business=Business::findBusiness($user->business_id);
        if(empty($business->public_key) || empty($business->secret_key))
        {
            $this->data['checkKey'] = 0;
        }else{
            $this->data['checkKey'] = 1;
        }
        $this->data['module'] = 'Business Services ' . 'List ';
        $this->data['subServices']=BusinessSubServices::listSubServicesBusinessWise($user->business_id);

        if(empty($request->sub_service) && empty($request->name) && empty($request->price) && empty($request->time))
        {
            $this->data['list'] = BusinessSubServices::getSubServices($user->business_id);
        }else{
            $this->data['list'] = BusinessSubServices::getSubServicesByFilter($user->business_id,$request->sub_service,$request->name,$request->price,$request->time);
        }

        return view('business.business-sub-services.index', $this->data);
    }
    public function create()
    {
        $this->data['module'] = 'Business Services ' . 'Add ';
        $business_id = Auth::guard('business_user')->user()->business_id;
        $businessServiceId = Business::findBusiness($business_id)->service_id;
        $this->data['subService'] = SubService::listSubServicesByServiceIdBusinessId($businessServiceId,$business_id);
        $this->data['teamMembers'] = BusinessTeamMember::listBusinessTeamMembers($business_id);
        return view('business.business-sub-services.create', $this->data);
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {
           
            $business_id = Auth::guard('business_user')->user()->business_id;

            $createService = ([
                "name" => $request->name,
                "business_id" => $business_id,
                "sub_service_id" => $request->business_service_id,
                "time" => $request->time,
                "created_at" => now(),
                "created_by" => Auth::guard('business_user')->user()->id,
            ]);

            $file_name = '';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = FileUploadTrait::image_upload($file, 'assets/images/services/');
            }

            if ($file_name != '') {
                $createService['image'] = $file_name;
            }

            $service = BusinessSubServices::create($createService);
            $last_inserted_id = $service->id;

            $input2['business_sub_services_id'] = $last_inserted_id;

            $team_member_id = $request->input('team_member_id');
            $team_price = $request->input('team_price');
            if (!empty($team_member_id)) {
                for ($i = 0; $i < count($team_member_id); $i++) {
                    $input2['team_member_id'] =  $team_member_id[$i];
                    $input2['price'] = $team_price[$i];
                    $input2['created_at'] = now();
                    ProductWiseTeamMember::create($input2);
                }
            }


            if ($service) {
                Session::flash('success', 'Business service ' . trans('messages.createdSuccessfully'));
                return redirect('business-owner-subservices');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-owner-subservices');
            }
        }
    }
    public function edit($id)
    {
        $data['module'] = 'Business Services ' . 'Edit ';
        $business_id = Auth::guard('business_user')->user()->business_id;
        $businessServiceId = Business::findBusiness($business_id)->service_id;
        $data['service'] = SubService::listSubServicesByServiceIdBusinessId($businessServiceId,$business_id);
        $data['subService'] = BusinessSubServices::findSubServices($id);
        $data['teamMembers'] = BusinessTeamMember::listBusinessTeamMembers($business_id);
        return view('business.business-sub-services.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules1($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {

            $updateService = ([
                "name" => $request->name,
                "sub_service_id" => $request->business_service_id,
                "time" => $request->time,
                "updated_at" => now(),
                "updated_by" => Auth::guard('business_user')->user()->id,
            ]);

            $file_name = '';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = FileUploadTrait::image_upload($file, 'assets/images/services/');
            }

            if ($file_name != '') {
                $updateService['image'] = $file_name;
            }

            ProductWiseTeamMember::where('business_sub_services_id',$id)->delete();

            $service = BusinessSubServices::updateSubServices($id, $updateService);

            $input2['business_sub_services_id'] = $id;

            $team_member_id = $request->input('team_member_id');
            $team_price = $request->input('team_price');


            if (!empty($team_member_id)) {
                for ($i = 0; $i < count($team_member_id); $i++) {
                    $input2['team_member_id'] =  $team_member_id[$i];
                    $input2['price'] = $team_price[$i];
                    $input2['created_at'] = now();
                    $temp=ProductWiseTeamMember::create($input2);
                }
            }

            if ($service) {
                Session::flash('success', 'Business service ' . trans('messages.updatedSuccessfully'));
                return redirect('business-owner-subservices');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('business-owner-subservices');
            }
        }
    }
    public function destroy($id)
    {
        $deleteArray = ([
            "deleted_by" => Auth::guard('business_user')->user()->id,
        ]);
        BusinessSubServices::updateSubServices($id, $deleteArray);

        $teamMember = BusinessSubServices::deleteSubServices($id);

        if ($teamMember) {
            Session::flash('success', 'Business service ' . trans('messages.deletedSuccessfully'));
            return redirect('business-owner-subservices');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('business-owner-subservices');
        }
    }
    public function updateSubServiceStatus(Request $request)
    {
        $teamMemberUpdateStatus = BusinessSubServices::findSubServices($request->id);
        $st = $teamMemberUpdateStatus->status == 1 ? 0 : 1;
        $teamMemberUpdateStatus->update(["status" => $st]);
        return $st;
    }
    public function getTeamMembersPrice(Request $request)
    {
        $check=BusinessTeamMember::findBusinessTeamMember($request->teamMember);

        if(!empty($check))
        {
            return response()->json(["status"=>true,"data"=>$check,"error_msg"=>"Sucess"]);
        }
        else
        {
            return response()->json(["status"=>false,"error_msg"=>"Error"]);
        }
    }
}
