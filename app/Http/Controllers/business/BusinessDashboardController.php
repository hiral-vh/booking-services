<?php

namespace App\Http\Controllers\business;

use App\Models\Business;
use App\Models\Services;
use App\Models\BusinessPayment;
use App\Models\BusinessUser;
use Illuminate\Http\Request;
use App\Models\BusinessRecurringPaymentHistory;
use App\Http\Controllers\Controller;
use App\Models\BusinessAppointment;
use App\Models\BusinessSubServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\StripeFunctionsTrait;
use App\Models\AppointmentPayment;
use DB;
use Carbon\Carbon;

// use App\Models\SiteSetting;

class BusinessDashboardController extends Controller
{
    use StripeFunctionsTrait;

    public function index(Request $request)
    {
      
       
        $user = Auth::guard('business_user')->user();
        $data['totalRevenue'] = AppointmentPayment::getTotalAmountSumByBusinessId($user->business_id);
        $data['services'] = BusinessSubServices::countSubServices($user->business_id);
        $data['TotalPayments'] = AppointmentPayment::getTotalPaymentByBusinessId($user->business_id);
        $data['module'] = 'Business Dashboard';
        $data['getBusinessData'] = Business::find($user->business_id);

        $startDate = date('Y-m-d H:i:s');
        $getEnddate = BusinessRecurringPaymentHistory::where('business_id', $user->business_id)->whereNull('deleted_at')->orderBy('id', 'desc')->first();
        $day = '';
        if ($getEnddate) {
            $date1_ts = strtotime($startDate);
            $date2_ts = strtotime($getEnddate->end_date);
            $diff = $date2_ts - $date1_ts;
            $day =  round($diff / 86400);
        }
        $data['diffrenceDay'] = $day;

        return view('business-dashboard', $data);
    }
    public function topup_orders(Request $request)
    {
        $total_order = $request->total_order;
        $total_days = $request->total_days;
        if ($total_order != '' && $total_days != '') {

            $businessId = Auth::guard('business_user')->user()->business_id;
            $insertArray = array(
                'business_id' => $businessId,
                'total_appointment' => $total_order,
                'total_days' => $total_days,
                'payment_type' => 'top_up',
                'created_at' => date('Y-m-d H:i:s')
            );
            $insert = new BusinessPayment($insertArray);
            $insert->save();
            $payment = $insert->id;

            return redirect()->route('makepaymentTopup', [$businessId, $payment]);
        } else {
            Session::flash('error', 'Something went wrong');
            return redirect('business-dashboard');
        }
    }
    public function makepaymentTopup($businessId, $businessStripeId)
    {
        return view('admin.make-paymenttopup', ['userId' => $businessId, 'paymentID' => $businessStripeId]);
    }
    public function createPaymentSessiontopup(Request $request)
    {
        $sessionId = $this->topAmountCustomer($request->user_id, $request->payment_id);
        return response()->json(['id' => $sessionId]);
    }

    public function paymentSuccessTopup($paymentId)
    {
        $businessId = Auth::guard('business_user')->user()->business_id;
        $payment = BusinessPayment::find($paymentId);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $paymentResponse = $stripe->checkout->sessions->retrieve(
            $payment->payment_request_id,
            []
        );

        $update = BusinessPayment::where('id', $paymentId)->update(array('payment_status' => $paymentResponse->payment_status, 'created_by' => date('Y-m-d'), 'gateway_response' => $paymentResponse));
        $allowed_order = $payment->total_appointment;
        Business::where('id', $businessId)->update(array('numbers_of_appointment' => $allowed_order));
        Session::flash('success', 'Orders Top Up successfully');
        return redirect('business-dashboard');
    }
    public function paymentFailedTopup($paymentId)
    {
        $payment = BusinessPayment::find($paymentId);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $paymentResponse = $stripe->checkout->sessions->retrieve(
            $payment->payment_request_id,
            []
        );

        $update = BusinessPayment::where('id', $paymentId)->update(array('payment_status' => $paymentResponse->payment_status, 'gateway_response' => $paymentResponse));
        Session::flash('error', 'Payment Failed');
        return redirect('business-dashboard');
    }
    public function stripeKeyUpdate(Request $request)
    {

        $businessId = Auth::guard('business_user')->user()->business_id;
        $update = Business::where('id', $businessId)->update(['public_key' => $request->stripe_public_key, 'secret_key' => $request->stripe_secret_key]);

        if ($update) {
            Session::flash('success', 'Stripe key update Successfully');
            return redirect()->route('business-profile');
        } else {
            Session::flash('error', 'Something went wrong');
            return redirect()->route('business-profile');
        }
    }
    public function getMonthlyData(Request $request)
    {
        $searchType = $request['searchType'];
        $businessId = Auth::guard('business_user')->user()->business_id;
        $finalArray = array();

       

        if($request->listType == 'Appointments')
        {
            if($request->filter == '1'){
                    $getDate = explode('-',$request->dates);
                    $fromDate = date('Y-m-d',strtotime($getDate[0]));
                    $toDate = date('Y-m-d',strtotime($getDate[1]));
                    for ($i=strtotime($fromDate); $i<=strtotime($toDate); $i+=86400) {  
                        $date = date("Y-m-d", $i);
                        $appointments = BusinessAppointment::whereDate('appointment_date','=',$date)->where('business_id',$businessId)->count();
                        $finalArray[] = array('allDates' => date("d",strtotime($date)),"totalCount" => $appointments);
                    } 
                    return json_encode($finalArray);
            }
            if($searchType==null)
            {
                
                for($i = 1; $i <=  date('t'); $i++)
                {
                    
                    $checkDate = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $appointments = BusinessAppointment::whereDate('appointment_date','=',$checkDate)->where('business_id',$businessId)->count();
                    $finalArray[] = array('allDates' => date("d",strtotime($checkDate)),"totalCount" => $appointments);
                }
                return json_encode($finalArray);
            }else if($searchType=="week"){

                $checkDayDate = date("Y-m-d"); 
                $week = [];
                $carbaoDay = Carbon::createFromFormat('Y-m-d', $checkDayDate);
                for($i = 1; $i <= 7; $i++)
                {
                    $week = $carbaoDay->startOfWeek()->addDay($i)->format('Y-m-d');
                    $weekappointments = BusinessAppointment::whereDate('appointment_date','=',$week)->where('business_id',$businessId)->count();
                    $finalArray[] = array('allDates' => date("d",strtotime($week)),"totalCount" => $weekappointments);
                }
                return json_encode($finalArray);
            }
            else
            {
                $checkDayDate = date("Y-m-d"); 
                $weekappointments = BusinessAppointment::whereDate('appointment_date','=',$checkDayDate)->where('business_id',$businessId)->count();
                $finalArray[] = array('allDates' => date("d-m-y",strtotime($checkDayDate)),"totalCount" => $weekappointments);

                return json_encode($finalArray);
            }
           
        }   
        if($request->listType == 'revenue')
        {

            if($request->filter == '1'){
                $getDate = explode('-',$request->dates);
                    $fromDate = date('Y-m-d',strtotime($getDate[0]));
                    $toDate = date('Y-m-d',strtotime($getDate[1]));
                    
                    for ($i=strtotime($fromDate); $i<=strtotime($toDate); $i+=86400) {  
                        $date = date("Y-m-d", $i);
                        $appointments = AppointmentPayment::select(DB::raw("(sum(total_amount)) as revenue"))->whereDate('created_at','=',$date)->where('business_id',$businessId)->sum('total_amount');
                        $finalArray[] = array('allDates' => date("d",strtotime($date)),"totalCount" => $appointments);
                    } 
                    return json_encode($finalArray);
            }

            if($searchType==null)
            {
                for($i = 1; $i <=  date('t'); $i++)
                {
                   
                    $checkDate = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $appointments = AppointmentPayment::select(DB::raw("(sum(total_amount)) as revenue"))->whereDate('created_at','=',$checkDate)->where('business_id',$businessId)->sum('total_amount');
                    $finalArray[] = array('allDates' => date("d",strtotime($checkDate)),"totalCount" => $appointments);
                }

                return json_encode($finalArray);
            }
            else if($searchType=="week")
            {
                $checkDayDate = date("Y-m-d"); 
                $week = [];
                $carbaoDay = Carbon::createFromFormat('Y-m-d', $checkDayDate);
                for($i = 1; $i <= 7; $i++)
                {
                    $week = $carbaoDay->startOfWeek()->addDay($i)->format('Y-m-d');
                    $appointments = AppointmentPayment::select(DB::raw("(sum(total_amount)) as revenue"))->whereDate('created_at','=',$week)->where('business_id',$businessId)->sum('total_amount');
                    $finalArray[] = array('allDates' => date("d",strtotime($week)),"totalCount" => $appointments);
                } 
                return json_encode($finalArray);
            }
            else
            {
                $checkDayDate = date("Y-m-d"); 
                $appointments = AppointmentPayment::select(DB::raw("(sum(total_amount)) as revenue"))->whereDate('created_at','=',$checkDayDate)->where('business_id',$businessId)->sum('total_amount');
                $finalArray[] = array('allDates' => date("d-m-y",strtotime($checkDayDate)),"totalCount" => $appointments);

                return json_encode($finalArray);
            }
        }   
        
        if($request->listType == 'services')
        { 
            if($request->filter == '1'){
                $newArray = array();
                $getDate = explode('-',$request->dates);
                    $fromDate = date('Y-m-d',strtotime($getDate[0]));
                    $toDate = date('Y-m-d',strtotime($getDate[1]));
                    
                    for ($i=strtotime($fromDate); $i<=strtotime($toDate); $i+=86400) {  
                        $date = date("Y-m-d", $i);

                        $appointments = BusinessAppointment::with('subService')->where('business_id',$businessId)->whereDate('appointment_date','=',$date)->groupBy('sub_services_id')->get();

                        foreach($appointments as $data)
                        {
                            $servciesWise = BusinessAppointment::where('business_id',$businessId)->whereDate('appointment_date','=',$checkDate)->where('sub_services_id',$data->sub_services_id)->count();
    
                            $newArray[] = array('allDates' => $data->subService->name,'totalCount' => $servciesWise); 
                        }
                    } 
                    return json_encode($newArray);
            }
            if($searchType==null)
            {
                $newArray = array();
                $temp_array = array();
                for($i = 1; $i <=  date('t'); $i++)
                {
                    
                    $checkDate = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
                   
                    $appointments = BusinessAppointment::with('subService')->where('business_id',$businessId)->whereDate('appointment_date','=',$checkDate)->groupBy('sub_services_id')->get();
                    
                     
                     
                    foreach($appointments as $data)
                    {
                        $servciesWise = BusinessAppointment::where('business_id',$businessId)->where('sub_services_id',$data->sub_services_id)->count();
                        
                        if(in_array($data->sub_services_id,$temp_array)){
                           
                        }else{
                            $newArray[] = array('allDates' => $data->subService->name,'totalCount' => $servciesWise);
                            $temp_array[] = $data->sub_services_id;
                         
                        }  
                    }
                }
               
              return json_encode($newArray);
            }else if($searchType=="week"){
                $newArray = array();
                $temp_array = array();
                $checkDayDate = date("Y-m-d"); 
                $week = [];
                $carbaoDay = Carbon::createFromFormat('Y-m-d', $checkDayDate);
                for($i = 0; $i < 7; $i++)
                {
                    $week = $carbaoDay->startOfWeek()->addDay($i)->format('Y-m-d');
                    $appointments = BusinessAppointment::with('subService')->where('business_id',$businessId)->whereDate('appointment_date','=',$week)->groupBy('sub_services_id')->get();
                    foreach($appointments as $data)
                    {
                        $servciesWise = BusinessAppointment::where('business_id',$businessId)->whereDate('appointment_date','=',$week)->where('sub_services_id',$data->sub_services_id)->count();

                        if(in_array($data->sub_services_id,$temp_array)){
                           
                        }else{
                            $newArray[] = array('allDates' => $data->subService->name,'totalCount' => $servciesWise);
                            $temp_array[] = $data->sub_services_id;
                         
                        } 
                    }
                    // if(empty($newArray))
                    // {
                    //     $newArray[] = array('allDates' => date('d-m-y',strtotime($week)),'totalCount' => 0); 
                    // }
                    
                }
                return json_encode($newArray);
            }
            else
            {
                $newArray = array();
                $temp_array = array();
                $checkDayDate = date("Y-m-d"); 
                $appointments = BusinessAppointment::with('subService')->where('business_id',$businessId)->whereDate('appointment_date','=',$checkDayDate)->groupBy('sub_services_id')->get();
                
                foreach($appointments as $data)
                {
                    $servciesWise = BusinessAppointment::where('business_id',$businessId)->whereDate('appointment_date','=',$checkDayDate)->where('sub_services_id',$data->sub_services_id)->count();

                   
                    if(in_array($data->sub_services_id,$temp_array)){
                           
                    }else{
                        $newArray[] = array('allDates' => $data->subService->name,'totalCount' => $servciesWise);
                        $temp_array[] = $data->sub_services_id;
                     
                    }  
                }
                if(empty($newArray))
                {
                    $newArray[] = array('allDates' => date('d-m-y',strtotime($checkDayDate)),'totalCount' => 0); 
                }
                return json_encode($newArray);
            }
           
        }
        
    }
   
}
