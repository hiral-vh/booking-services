<?php

namespace App\Http\Controllers\business;

use App\Models\Business;
use App\Models\SiteSetting;
use App\Models\BusinessAppointment;
use App\Models\Notification;
use App\Helpers\NotificationHelper;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ImageUploadTrait;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Session;


class AppointmentsController extends Controller
{
    use ImageUploadTrait;

    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }

    public function index(Request $request)
    {
        $this->data['module'] = 'Business Appointment List';
        return view('business.business-appointment.index', $this->data);
    }

    public function index1(Request $request)
    {
        $this->data['module'] = 'Business Appointment List';
        $user=Auth::guard('business_user')->user();
        $this->data['appointment'] = BusinessAppointment::getAppointment($user->business_id);
      
        return view('business.business-appointment.index-tableview', $this->data);
    }

    public function getBusinessAppointment(Request $request)
    {
        $user = Auth::guard('business_user')->user();
        $businessAppointment = BusinessAppointment::listAppointment($user->business_id);

        return response()->json($businessAppointment);
    }
    public function getAppointmentsByDate(Request $request)
    {
        $user = Auth::guard('business_user')->user();
        $details = BusinessAppointment::getAppointmentsByDate($request->detailsDate,$user->business_id);

        return response()->json($details);
    }
    public function changeAppointmentStatus(Request $request)
    {
        $update_status = BusinessAppointment::where('id', $request->id)->update(['appointment_status' => 'Cancel', 'cancel_reason' => $request->reason, 'cancel_datetime' => date('Y-m-d h:i:s')]);

        $appointments = BusinessAppointment::where('id',$request->id)->orderBy('id','desc')->first();
        $business = Business::select('name')->where('id',$appointments->business_id)->first();
        $userToken = User::select('device_token')->where('id',$appointments->user_id)->first();
        $dateTime = $appointments->appointment_date.' '.$appointments->appointment_time;

        $detailsArray = [
            'sender_id' => $appointments->business_id,
            'receiver_id' => $appointments->user_id,
            'title' => "Appointment Cancelled",
            'message'=> "Your booked appointment with ".$business->name." on ".$dateTime." has been cancelled due to ".$appointments->cancel_reason,
            'appointment_id'=>$appointments->id,
            'notification_type'=>4,
        ];
        $message = "Your booked appointment with ".$business->name." on  ".$dateTime." has been cancelled";
        $title = "Appointment Cancelled";
        Notification::createNotification($detailsArray);

        $NotificationData =  array('message' => $message, 'body' => 'Mark as unread', "title" => $title, "appointment_id" => $appointments->id);

        if (!empty($userToken->device_token)) {
            NotificationHelper::pushToGoogle(array($userToken->device_token), $NotificationData);
            $update = BusinessAppointment::where('id',$request->id)->update(array('notification_send' => '1'));
        }
      
        return $update_status;
    }

    public function getAppointmentDetails($id)
    {
        $this->data['appointment']=BusinessAppointment::getAppointmentsById($id);
        $this->data['module'] = 'Business Appointment Details';
        return view('admin.business-appointment.appointment-detail',$this->data);
    }
    public function updateAppointmentStatus(Request $request)
    {
       
        $update_status = BusinessAppointment::where('id', $request->appointment_id)->update(['appointment_status' => $request->status, 'updated_at' => date('Y-m-d h:i:s')]);

        $appointments = BusinessAppointment::where('id',$request->appointment_id)->orderBy('id','desc')->first();
        $business = Business::select('name')->where('id',$appointments->business_id)->first();
        $userToken = User::select('device_token')->where('id',$appointments->user_id)->first();
        $dateTime = $appointments->appointment_date.' '.$appointments->appointment_time;

        if($request->status == 'Confirm')
        {
            $detailsArray = [
                'sender_id' => $appointments->business_id,
                'receiver_id' => $appointments->user_id,
                'title' => "Appointment Confirmed",
                'message'=> "Your booked appointment with ".$business->name." on  ".$dateTime."  has been confirmed",
                'appointment_id'=>$appointments->id,
                'notification_type'=>3,
            ];
            $message = "Your booked appointment with ".$business->name." on  ".$dateTime."  has been confirmed";
            $title = "Appointment Confirmed";
            Notification::createNotification($detailsArray);

            $NotificationData =  array('message' => $message, 'body' => 'Mark as unread', "title" => $title, "appointment_id" => $appointments->id);
            if (!empty($userToken->device_token)) {
                NotificationHelper::pushToGoogle(array($userToken->device_token), $NotificationData);
                $update = BusinessAppointment::where('id',$request->appointment_id)->update(array('notification_send' => '1'));
            }
        }

        if($request->status == 'Complete')
        {
            $detailsArray = [
                'sender_id' => $appointments->business_id,
                'receiver_id' => $appointments->user_id,
                'title' => "Appointment Completed",
                'message'=> "Your booked appointment with ".$business->name." on  ".$dateTime."  has been completed",
                'appointment_id'=>$appointments->id,
                'notification_type'=>3,
            ];
            $message = "Your booked appointment with ".$business->name." on  ".$dateTime."  has been completed";
            $title = "Appointment Completed";
            Notification::createNotification($detailsArray);

            $NotificationData =  array('message' => $message, 'body' => 'Mark as unread', "title" => $title, "appointment_id" => $appointments->id);
            if (!empty($userToken->device_token)) {
                NotificationHelper::pushToGoogle(array($userToken->device_token), $NotificationData);
                $update = BusinessAppointment::where('id',$request->appointment_id)->update(array('notification_send' => '1'));
            }
        }
        

        if($update_status)
        {
            Session::flash('success', 'Status  ' . trans('messages.updatedSuccessfully'));
            return redirect()->back();
        }
        else{
            Session::flash('error', trans('messages.errormsg'));
            return redirect()->back();
        }
    }
}
