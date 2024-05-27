<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductWiseTeamMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Http\Traits\ImageUploadTrait;
use App\Models\BusinessAppointment;

class BusinessAppointmentController extends Controller
{
    use ImageUploadTrait;


    public function index(Request $request)
    {
        $this->data['userName'] = $userName = $request->userName;
        $this->data['mobile'] = $mobile = $request->mobile;
        $this->data['business'] = $business = $request->business;
        $this->data['sub_service'] = $subService = $request->sub_service;
        $this->data['business_sub_service'] = $businessSubService = $request->business_sub_service;
        $this->data['business_team_member'] = $businessTeamMember = $request->business_team_member;
        $this->data['appointment_date'] = $appointmentDate = $request->appointment_date;
        $this->data['appointment_time'] = $appointmentTime = $request->appointment_time;

        $businessAppointment = BusinessAppointment::listAppointmentInSuperAdmin($userName, $mobile,$business,$subService,$businessSubService,$businessTeamMember,$appointmentDate,$appointmentTime);
        $allBusinessAppointment = BusinessAppointment::listAllAppointmentInSuperAdmin();

        foreach ($businessAppointment as $value) {
            $getPrice = ProductWiseTeamMember::where('business_sub_services_id', $value->business_sub_services_id)->where('team_member_id', $value->business_team_members_id)->first();
            if (!empty($getPrice)) {
                $value->price = $getPrice->price;
            } else {
                $value->price = 0;
            }
        }

        $this->data['businessAppointment'] = $businessAppointment;
        $this->data['allBusinessAppointment'] = $allBusinessAppointment;
        $this->data['module'] = 'Business Appointment List';
        return view('admin.business-appointment.index', $this->data);
    }

    public function canceleAppointmentList(Request $request)
    {
        $this->data['userName'] = $userName = $request->userName;
        $this->data['mobile'] = $mobile = $request->mobile;
        $this->data['business'] = $business = $request->business;
        $this->data['sub_service'] = $subService = $request->sub_service;
        $this->data['business_sub_service'] = $businessSubService = $request->business_sub_service;
        $this->data['business_team_member'] = $businessTeamMember = $request->business_team_member;
        $this->data['appointment_date'] = $appointmentDate = $request->appointment_date;
        $this->data['appointment_time'] = $appointmentTime = $request->appointment_time;

        $this->data['canceleAppointmentListFilter']=BusinessAppointment::canceleAppointmentListSearchInSuperAdmin($userName, $mobile,$business,$subService,$businessSubService,$businessTeamMember,$appointmentDate,$appointmentTime);
        $this->data['canceleAppointmentList'] = BusinessAppointment::canceleAppointmentListInSuperAdmin();
        $this->data['module'] = 'Cancelled Appointment List';

        return view('admin.business-appointment.canceleappointmentlist', $this->data);
    }
}
