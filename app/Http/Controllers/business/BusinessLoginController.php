<?php

namespace App\Http\Controllers\business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Services;
use App\Models\SiteSetting;
use App\Models\Subcription;
use App\Models\BusinessPayment;
use App\Models\BusinessRecurringPaymentHistory;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Traits\MailSendTrait;
use App\Models\BusinessUser;
use App\Models\Notification;
use App\Models\BusinessWeekSchedule;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ImageUploadTrait;
use App\Http\Traits\StripeFunctionsTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

class BusinessLoginController extends Controller
{
    use ImageUploadTrait;
    use MailSendTrait;
    use StripeFunctionsTrait;

    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }

    protected $validationRules = [
        'email'    => 'required|email|unique:users,email',
        'password' => 'required',
    ];

    public function appDownloadLink()
    {
        return view('app-download-page', $this->data);
    }

    public function register()
    {
        $this->data['service'] = Services::listServices();
        $this->data['module'] = "Business Register";
        return view('auth.business.business-user-register', $this->data);
    }

    public function storeRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'email'                 => 'required|email|unique:business_users,email',
            'password'              => 'required|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/|min:8',
            'confirm_password'      => 'required|same:password',
            'business_name'         => 'required|string|max:255',
            'business_email'        => 'required|email',
            'business_contact'      => 'required|numeric',
            'address_line1'         => 'required|max:255',
            'address_line2'         => 'required|max:255',
            'city'                  => 'required|max:255',
            'zip_code'              => 'required|numeric',
            'service'               => 'required',
            'terms_and_conditions'  => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'login')->withInput();
        } else {
 
            $businessArray = [
                'service_id' => $request->service,
                'name' => $request->business_name,
                'email' => $request->business_email,
                'country_code' => "+44",
                'latitude'=>$request->latitude,
                'longitude'=>$request->longitude,
                'contact' => $request->business_contact,
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
                'numbers_of_appointment' => 100,
                'subscription_flag' => 2,
                'created_at' => now(),
            ];

            $business = Business::createBusiness($businessArray);

            if($business)
            {
                $getReceiverId = Admin::first();
                $details = [
                    'sender_id' => $business->id,
                    'receiver_id' => $getReceiverId->id,
                    'title' => $business->name.' has registered in the Book-IT portal.',
                    'message'=>'Mark as unread',
                    'appointment_id'=>'',
                    'notification_type'=>7,
                ];
                Notification::createNotification($details);
            }
            $password = Hash::make($request->password);

            $businessUserArray = [
                'business_id' => $business->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $request->first_name . " " . $request->last_name,
                'email' => $request->email,
                'password' => $password,
                'created_at' => now(),
            ];

            
            // $businessWeekSchedule=array();
            // foreach($request->day as $value) {
            //     $businessWeekSchedule['business_id']= $business->id;
            //     $businessWeekSchedule['day']=$value;
            //     $businessWeekSchedule['open_time']= $request->opening_time;
            //     $businessWeekSchedule['close_time']= $request->closing_time;
            //     $businessWeekSchedule['break_start_time']= $request->break_start_time;
            //     $businessWeekSchedule['break_end_time']= $request->break_end_time;
            //     $businessWeekSchedule['created_at']= now();
            //     BusinessWeekSchedule::create($businessWeekSchedule);
            
            // }

         
            $file_name = '';
            if ($request->hasFile('image')) {
                $file_name = $this->uploadImage($request->file('image'), 'business/images/user/');
            }

            if ($file_name != '') {
                $businessUserArray['profile_image'] = $file_name;
            }

            $this->data['user'] = $user = BusinessUser::createBusinessUser($businessUserArray);

            User::updateUser($user->id, ['created_by' => $user->id]);
            Business::updateBusiness($business->id, ['created_by' => $user->id]);

            $businessRecurringPaymentHistoryArray=array(
                'business_id'       =>      $business->id,
                'plan_id'           =>      1,
                'start_date'        =>      now(),
                'end_date'          =>      date('Y-m-d h:i:s', strtotime(now().'+1 month')),
            );

            BusinessRecurringPaymentHistory::createBusinessRecurringPaymentHistory($businessRecurringPaymentHistoryArray);
            $html = view('verify-business-user', $this->data);

            $email = $this->sendMail($html, $request->email, 'Verify your email please');

            if ($email) {
                Session::flash('success', 'Email has been sent successfully please verify');
                return redirect()->route('business-login');
            }
        }
    }

    public function checkBusinessUser($email)
    {
        $user = BusinessUser::getUserByEmail($email);
        //$auth = Auth::guard('business_user')->loginUsingId($user->id);
        BusinessUser::updateUser($user->id, ['is_verify' => 1]);
        Session::flash('success', 'Your email is successfully verified.');
        return redirect()->route('business-login');
        // if ($auth) {
        //     $getUserData = Business::find($auth->business_id);
        //     if ($getUserData->subscription_flag == '0') {

        //         Session::flash('success', 'Please buy subscription');
        //         return redirect('subscription');
        //     } else {
        //         Session::flash('success', 'Your email is successfully verified.');
        //         return redirect()->route('business-dashboard');
        //     }
        // }
    }

    public function login()
    {
        if (Auth::guard('business_user')->check()) {
            $this->data['module'] = 'Business Dashboard';
            return redirect()->route('business-dashboard');
        }
        $this->data['module'] = 'Business Login';
        return view('auth.business.login', $this->data);
    }

    public function checkCreadentials(Request $request)
    {
        
        $validator = Validator::make($request->all(), [ //use facade validator library
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'login')->withInput();
        } else {
            $credentials = array('email' => $request->email, 'password' => $request->password);
            
            if (auth()->guard('business_user')->attempt($credentials)) {
                $user=Auth::guard('business_user')->user();
              
                if($user->is_verify != 1)
                {
                    Auth::guard('business_user')->logout();
                    Session::flash('error', 'Profile is under verification Please check the registered email');
                    return redirect()->back()->withInput();
                }else{
                    
                    $getUserData = Business::find(Auth::guard('business_user')->user()->business_id);
                   
                    if ($getUserData->subscription_flag == '0') {
                        //Session::flash('success', 'Please buy subscription.');
                        //return redirect('subscription');
                        $token =  response()->json(['route' => route('subscription'),'status'=>'1','message'=>'Please buy subscription.']);
                    }elseif($getUserData->public_key == null && $getUserData->secret_key == null){
                        //return redirect()->route('business-profile');
                        $token =  response()->json(['route' =>route('business-profile'),'status'=>'1','message'=>'']);

                    } else {
                       // Session::flash('success', 'You are successfully logged in.');
                        //return redirect()->route('business-dashboard');
                        $token =  response()->json(['route' =>route('business-dashboard'),'status'=>'1','message'=>'You are successfully logged in.']);

                    }
                    return $token;
                }
            } else {
                Session::flash('error', 'Email or password is invalid');
                return redirect()->back()->withInput();
            }
        }
    }

    public function checkEmail(Request $request)
    {
        $userEmail = BusinessUser::getUserByEmail($request->email);

        if ($userEmail) {
            return response()->json(['message' => 'exist']);
        } else {
            return response()->json(['message' => 'not_exist']);
        }
    }

    public function logout(Request $request)
    {
        $update = Business::where('id', Auth::guard('business_user')->user()->business_id)->update(array('device_token' => NULL));
        Auth::guard('business_user')->logout();
        return redirect()->route('business-login');
    }

    public function subscription(Request $request)
    {
        $data['getAllsubscription'] = Subcription::getAllsubscription();
        return view('admin.subscription', $data);
    }
    public function upgradeSubscription(Request $request)
    {
        $businessId = Auth::guard('business_user')->user()->business_id;
        $data['getAllsubscription'] = $subscription = Subcription::getAllsubscription();
        $getPlans = BusinessRecurringPaymentHistory::where('business_id',$businessId)->orderBy('id','desc')->first(); 
        $data['plan_id'] = '';
        if($getPlans){
            $data['plan_id'] = $getPlans->plan_id;
        }

        // $getPlanName = Subcription::where('id',$getPlans->plan_id)->first();

        // $details = [
        //     'sender_id' =>'',
        //     'receiver_id' => $businessId,
        //     'title' => "Your subscription upgraded with ".$getPlanName->plan_name,
        //     'message'=>'Mark as unread',
        //     'appointment_id'=>'',
        //     'notification_type'=>15,
        // ];
        // Notification::createNotification($details);
       
        return view('admin.upgrade-subscription', $data);
    }
    public function cancelSubscription(Request $request)
    {
        $businessId = Auth::guard('business_user')->user()->business_id;
        $getPayment = BusinessPayment::where('business_id',$businessId)->orderBy('id','desc')->first(); 
        

        if($getPayment->subscription_id == ''){
            Session::flash('error', 'No Subscription Found');
            return redirect()->back();
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        try{
            $customer = $stripe->subscriptions->cancel(
                $getPayment->subscription_id,
                []
            );
            Session::flash('success','Successfully Cancelled Subscription');
            if($customer)
            {
                $update = BusinessPayment::where('subscription_id', $getPayment->subscription_id)->update(array('subscriptionCancel' => 'Cancel'));

                $updatePayment = BusinessRecurringPaymentHistory::where('business_id',$getPayment->business_id)->where('plan_id',$getPayment->plan_id)->update(array('cancel_subscription'=>'cancel'));

                $getPlanName = Subcription::where('id',$getPayment->plan_id)->first();

                $details = [
                    'sender_id' =>'',
                    'receiver_id' => $getPayment->business_id,
                    'title' => "You had cancel your subscription plan ".$getPlanName->plan_name,
                    'message'=>'Mark as unread',
                    'appointment_id'=>'',
                    'notification_type'=>14,
                ];
                Notification::createNotification($details);

              
                return redirect()->back();
            }
        }catch(Exception $e){
            Session::flash('error','Something went Wrong.');
            return redirect()->back();
        } 
       
    }
    public function subscription_purchase(Request $request)
    {
        $businessId = Auth::guard('business_user')->user()->business_id;
        $businessStripe = $this->addStripeCustomer($businessId, $request->id);
        return redirect()->route('makePayment', [$businessId, $businessStripe]);
    }
    public function createPaymentSession(Request $request)
    {
        $sessionId = $this->CreateBusinessPaymentSession($request->business_id, $request->business_stripe_id);
        return response()->json(['id' => $sessionId]);
    }
    public function makePayment($businessId, $businessStripeId)
    {
        $businessStripe = Business::find($businessId);
        return view('admin.make-payment', ['businessId' => $businessId, 'businessStripe' => $businessStripeId]);
    }
    public function paymentSuccess($paymentId)
    {
        $payment = BusinessPayment::find($paymentId);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $paymentResponse = $stripe->checkout->sessions->retrieve(
            $payment->payment_request_id,
            []
        );

        $update = BusinessPayment::where('id', $paymentId)->update(array('payment_status' => $paymentResponse->payment_status, 'subscription_id' => $paymentResponse->subscription, 'gateway_response' => $paymentResponse));
        $businessId = Auth::guard('business_user')->user()->business_id;
        $subcriptionData=Subcription::where('id',$payment->plan_id)->first();
        Business::where('id', $businessId)->update(array('subscription_flag' => '1','numbers_of_appointment'=>$subcriptionData->allowed_order));
        $BusinessRecurringPaymentHistorySave= new BusinessRecurringPaymentHistory(array('business_id'=>$businessId,'plan_id'=>$payment->plan_id,'start_date'=>date('Y-m-d H:i:s'),'end_date'=>date("Y-m-d H:i:s", strtotime("+1 month"))));
        $BusinessRecurringPaymentHistorySave->save();

        $getPlanName = Subcription::where('id',$payment->plan_id)->first();

        $details = [
            'sender_id' =>'',
            'receiver_id' => $businessId,
            'title' => "Your subscription upgraded with ".$getPlanName->plan_name,
            'message'=>'Mark as unread',
            'appointment_id'=>'',
            'notification_type'=>15,
        ];
        Notification::createNotification($details);
        Session::flash('success', 'Subscription purchased successfully.');
        return redirect('business-dashboard');
    }

    public function paymentFailed($paymentId)
    {
        $payment = BusinessPayment::find($paymentId);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $paymentResponse = $stripe->checkout->sessions->retrieve(
            $payment->payment_request_id,
            []
        );

        $update = BusinessPayment::where('id', $paymentId)->update(array('payment_status' => $paymentResponse->payment_status, 'gateway_response' => $paymentResponse));
        Session::flash('error', 'Payment Failed.');
        return redirect('subscription');
    }


}
