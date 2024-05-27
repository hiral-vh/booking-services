<?php

namespace App\Http\Controllers\API\V1;

use Stripe;
use App\Models\Cms;
use App\Models\Faq;
use App\Models\User;
use App\Models\Business;
use App\Models\Services;
use App\Models\SubService;
use App\Models\TeamMembers;
use App\Models\UserAddress;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\BusinessOffer;
use App\Models\HelpAndSupport;
use App\Models\BusinessService;
use App\Models\UserCardDetails;
use App\Http\Traits\MailSendTrait;
use App\Models\AppointmentPayment;
use App\Models\BusinessTeamMember;
use App\Helpers\NotificationHelper;
use App\Models\BusinessAppointment;
use App\Models\BusinessSubServices;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Models\BusinessRecentVisits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ProductWiseTeamMember;
use Illuminate\Support\Facades\Validator;
use App\Models\BusinessTeamMemberTimeSlot;

class ApiController extends Controller
{
    use MailSendTrait;
    public $successStatus = 200;
    public function __construct()
    {
    }

    public function registerUser(Request $request)
    {
        $customMessage = array(
            "password.regex" => "Password must contain one uppercase, one lowercase and one number, one special character"
        );
        $validator = Validator::make($request->all(), [
            'first_name'       => 'required|max:255',
            'last_name'        => 'required|max:255',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/|min:8',
            'confirm_password' => 'required|same:password',
            'country_code'     => 'required',
            'mobile'           => 'required|numeric',
        ], $customMessage);

        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $password = Hash::make($request->password);
            $data_array = array(
                'first_name'   => $request->first_name,
                'last_name'    => $request->last_name,
                'name'         => $request->first_name . " " . $request->last_name,
                'email'        => $request->email,
                'password'     => $password,
                'country_code' => $request->country_code,
                'mobile'       => $request->mobile,
                'status'       => 1,
            );

            $save = User::createUser($data_array);

            if ($save) {
                return response()->json(['error_msg' => "User " . trans('messages.createdSuccessfully'), 'status' => 1, 'data' => array()], $this->successStatus);
            } else {
                return response()->json(['error_msg' => trans('messages.errormsg'), 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'           => 'required|email|max:255',
            'password'        => 'required',
        ]);
        if ($validator->fails()) {
            
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {          
          
            if (auth()->guard('web')->attempt(array('email' => $request->email, 'password' => $request->password, 'deleted_at' => NULL, 'status' => 1))) {
                $user =  Auth::guard('web')->user();  
                Auth::guard('web')->user()->tokens->each(function ($token, $key) {
                    $token->delete();
                });               
                $token = $user->createToken('MyApp')->plainTextToken;
                $user['remember_token'] = $token;
                $user->save();
                $userReturn = User::findUser($user->id);
                $userArray = ([
                    "id"            => $userReturn->id,
                    "first_name"    => $userReturn->first_name,
                    "last_name"     => $userReturn->last_name,
                    "email"         => $userReturn->email,
                    "mobile"        => $userReturn->mobile,
                    "profile_photo" => $userReturn->profile_photo_path,
                    "status"        => $userReturn->status,
                    "country_code"  => $userReturn->country_code,
                    "token"         => $token
                ]);
                return response()->json(['error_msg' => 'Login  successfully.', 'status' => 1, 'data' => array($userArray)], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Email or Password is incorrect.', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function userForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {

            $otp = mt_rand(10000, 99999);
            $updateOtp = ([
                "otp" => $otp,
            ]);
            User::updateUserByEmail($request->email, $updateOtp);
            $user = User::getUsersByEmail($request->email);

            $this->data['user'] = User::getUsersByEmail($request->email);
            $html = view('email', $this->data);
            $email = $this->sendMail($html, $request->email, 'Verify OTP');

            if ($email) {
                return response()->json(['error_msg' => 'OTP Sent Successfully.', 'status' => 1, 'data' => array("id" => $this->data['user']->id)], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Email Not Sent.', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function userVerifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'otp' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $id = $request->id;
            $otp = $request->otp;

            $verify = User::findUser($id);

            if ($verify) {
                if ($verify->otp == $otp) {
                    User::updateUser($verify->id, ["otp" => null]);
                    return response()->json(['error_msg' => 'OTP Verified Successfully.', 'status' => 1, 'data' => array()], $this->successStatus);
                } else {
                    return response()->json(['error_msg' => 'Please enter valid OTP', 'status' => 0, 'data' => array()], $this->successStatus);
                }
            } else {
                return response()->json(['error_msg' => 'User Id Not Found', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function resetPassword(Request $request)
    {
        $customMessage = array(
            "password.regex" => "Password must contain one uppercase, one lowercase and one number, one special character"
        );

        $validator = Validator::make($request->all(), [
            'id'               => 'required|numeric',
            'password'         => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
            'confirm_password' => 'required|same:password',
        ], $customMessage);

        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $id = $request->id;

            $verify = User::findUser($id);

            if ($verify) {
                $password = Hash::make($request->password);
                $update = User::updateUser($verify->id, ["password" => $password]);

                if ($update) {
                    return response()->json(['error_msg' => 'Password reset successfully.', 'status' => 1, 'data' => array()], $this->successStatus);
                } else {
                    return response()->json(['error_msg' => 'Password not reset', 'status' => 0, 'data' => array()], $this->successStatus);
                }
            } else {
                return response()->json(['error_msg' => 'User Id Not Found', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function getUserProfile(Request $request)
    {

        $user = User::findUser(Auth::user()->id);
        $userArray = ([
            "id" => $user->id,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "mobile" => $user->mobile,
            "profile_image" => $user->profile_photo_path,
            "status" => $user->status,
            "country_code" => $user->country_code,
        ]);

        if ($user) {
            return response()->json(['error_msg' => 'User Detail', 'status' => 1, 'data' => array($userArray)], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'User Not Found', 'status' => 0, 'data' => array()], $this->successStatus);
        }
    }

    public function updateUserProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name'       => 'required|string',
            'last_name'        => 'required|string',
            'mobile'           => 'required|numeric',
            'profile_image'    => 'image',
            'country_code'     => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $userArray = ([
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "name" => $request->first_name . " " . $request->last_name,
                "mobile" => $request->mobile,
                "country_code" => $request->country_code,
                "updated_at" => now(),
            ]);

            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $file_name = FileUploadTrait::image_upload($file, 'assets/images/users/');
                $userArray['profile_photo_path'] = $file_name;
            }


            $responseUserArray = ([
                "first_name" => $userArray['first_name'],
                "last_name" => $userArray['last_name'],
                "mobile" => $userArray['mobile'],
                "country_code" => $userArray['country_code'],
            ]);

            $userUpdate = User::updateUser($user->id, $userArray);
            if ($userUpdate) {
                return response()->json(['error_msg' => 'User Profile Updated Successfully', 'status' => 1, 'data' => array($responseUserArray)], $this->successStatus);
            } else {
                return response()->json(['error_msg' => trans('messages.errormsg'), 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email' . ($user->id ? ",$user->id,id" : ''),
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $emailArray = ([
                "email" => $request->email,
                "updated_at" => now(),
            ]);

            $userUpdate = User::updateUser($user->id, $emailArray);

            if ($userUpdate) {
                return response()->json(['error_msg' => "Email Updated Successfully", 'status' => 1, 'data' => array()], $this->successStatus);
            } else {
                return response()->json(['error_msg' => trans('messages.errormsg'), 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function updatePassword(Request $request)
    {
        $customMessage = array(
            "password.regex" => "Password must contain one uppercase, one lowercase and one number, one special character"
        );

        $user = Auth::user();
        $password = Hash::make($request->password);
        $validator = Validator::make($request->all(), [
            'current_password' => [
                'required',

                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Current Password Does Not Match.');
                    }
                }
            ],
            'password'         => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
            'confirm_password' => 'required|same:password',
        ], $customMessage);

        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $passwordArray = ([
                "password" => $password,
                "updated_at" => now(),
            ]);

            $userUpdate = User::updateUser($user->id, $passwordArray);
            if ($userUpdate) {
                return response()->json(['error_msg' => "Password updated successfully", 'status' => 1, 'data' => array()], $this->successStatus);
            } else {
                return response()->json(['error_msg' => trans('messages.errormsg'), 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function createUserAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_line1'    => 'required|max:255',
            'street'           => 'required|max:255',
            'city'             => 'required|max:255',
            'post_code'        => 'required|regex:/\b\d{6}\b/',
            'country_code'     => 'required',
            'mobile'           => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $user_address_array = array(
                'user_id'          => Auth::user()->id,
                'address_line1'    => $request->address_line1,
                'street'           => $request->street,
                'city'             => $request->city,
                'post_code'        => $request->post_code,
                'country_code'     => $request->country_code,
                'mobile'           => $request->mobile,
                'created_at'       => now(),
                'created_by'       => Auth::user()->id,
            );

            $save = UserAddress::createUserAddress($user_address_array);

            if ($save) {
                return response()->json(['error_msg' => "Address add Successfully", 'status' => 1, 'data' => array($user_address_array)], $this->successStatus);
            } else {
                return response()->json(['error_msg' => trans('messages.errormsg'), 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function createHelpAndSupport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name'        => 'required|max:255',
            'email'            => 'required|email',
            'message'          => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $help_and_support_array = array(
                'full_name'    => $request->full_name,
                'email'        => $request->email,
                'message'      => $request->message,
                'created_at'   => now(),
                'created_by'   => Auth::user()->id,
            );

            $save = HelpAndSupport::createHelpAndSupport($help_and_support_array);

            if ($save) {
                return response()->json(['error_msg' => 'Message Send Successfully', 'status' => 1, 'data' => array()], $this->successStatus);
            } else {
                return response()->json(['error_msg' => trans('messages.errormsg'), 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function updateUserAddress(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'address_line1'    => 'required|max:255',
            'street'           => 'required|max:255',
            'city'             => 'required|max:255',
            'post_code'        => 'required|regex:/\b\d{6}\b/',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {

            $user_address_array = array(
                'user_id'          => $user->id,
                'address_line1'    => $request->address_line1,
                'street'           => $request->street,
                'city'             => $request->city,
                'post_code'        => $request->post_code,
                'updated_at'       => now(),
                'updated_by'       => $user->id,
            );

            $checkAddressOrNot = UserAddress::getUserAddressById($user->id);
            if (empty($checkAddressOrNot)) {
                $userAddressUpdate = UserAddress::createUserAddress($user_address_array);
            } else {
                $userAddressUpdate = UserAddress::updateUserAddress($user->id, $user_address_array);
            }

            if ($userAddressUpdate) {
                return response()->json(['error_msg' => "Address update successfully", 'status' => 1, 'data' => array($user_address_array)], $this->successStatus);
            } else {
                return response()->json(['error_msg' => trans('messages.errormsg'), 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function getBusinessDetail(Request $request)
    {
        $servicesId = request('services_id');
        $business = Business::getBusinessList($servicesId);
        
        $businessArray = array();
       if(count($business) > 0){
        foreach($business as $bkey){
            $timeArray = array();
            if(count($bkey->businessWeekSchedule) > 0){
                foreach($bkey->businessWeekSchedule as $tkey){
                    $tkey->open_time = date("h:i A",strtotime($tkey->open_time));
                    $tkey->close_time = date("h:i A",strtotime($tkey->close_time));
                    $timeArray[] = $tkey;
                }
            }
            
            $bkey->business_week_schedule = $timeArray;
            $businessArray[] = $bkey;
        }
       }

        if ($businessArray) {
            return response()->json(['error_msg' => 'Businesses Detail', 'status' => 1, 'data' => $businessArray], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'Business Not Fetched', 'status' => 0, 'data' => array()], $this->successStatus);
        }
    }

    public function getBusinessById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_id'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {

            $user = Auth::user();
            $businessId = request('business_id');
            $business = Business::getBusinessById($businessId);
            $recentVisits = array('business_id' => $businessId, 'user_id' => $user->id, 'created_at' => date('Y-m-d H:i:s'));   
            //BusinessRecentVisits::createBusinessRecentVisits($recentVisits); 

            $insert = BusinessRecentVisits::updateOrCreate(
                [
                   'business_id'   => $businessId,
                   'user_id'   => $user->id,
                ],
                [
                    'created_at' => date('Y-m-d H:i:s')
                ],
            );

            if ($business) {
                return response()->json(['error_msg' => 'Businesses Detail', 'status' => 1, 'data' => array($business)], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Business Not Found', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function serviceList()
    {
        $ServicesList = Services::listServices();
        if ($ServicesList) {
            return response()->json(['error_msg' => 'Businesses Detail', 'status' => 1, 'data' => $ServicesList], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No Service List', 'status' => 0, 'data' => array()], $this->successStatus);
        }
    }

    public function getBusinessRecentVisits()
    {
        $user = Auth::user();
        $businessRecentVisits = BusinessRecentVisits::getRecentVisitsBusiness($user->id);
        if (count($businessRecentVisits) != 0) {
            return response()->json(['error_msg' => 'Business Recent Visits List', 'status' => 1, 'data' => $businessRecentVisits], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No Business Recent Visits List', 'status' => 0, 'data' => array()], $this->successStatus);
        }
    }

    public function getBusinessServiceAndSubService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_id'    => 'required',
            'service_id'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $user = Auth::user();
            $businessId = request('business_id');
            $businessServiceId = request('service_id');
            $businessSubServiceList = SubService::listSubServicesByServiceId($businessServiceId);
            foreach ($businessSubServiceList as $value) {
                $value->businesssubservices = BusinessSubServices::getListBusinessWiseAndSubServiceId($value->id, $businessId);
            }

            if (count($businessSubServiceList) != 0) {
                return response()->json(['error_msg' => 'getBusinessServiceAndSubService List', 'status' => 1, 'data' => $businessSubServiceList], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'No getBusinessServiceAndSubService List', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function bookAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_id'    => 'required',
            'sub_services_id'    => 'required',
            'business_sub_services_id'    => 'required',
            'business_team_members_id'    => 'required',
            'appointment_date'    => 'required',
            'appointment_time'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $user = Auth::user();
            $check = BusinessAppointment::checkDateAndTimeSlotAppointment(request('business_team_members_id'), request('appointment_date'), request('appointment_time'));
            if (!empty($check)) {
                return response()->json(['error_msg' => 'This time slot is already booked.', 'status' => 0, 'data' => array()], $this->successStatus);
            }
            $instArray = array(
                'user_id' => $user->id,
                'business_id' => request('business_id'),
                'sub_services_id' => request('sub_services_id'),
                'business_sub_services_id' => request('business_sub_services_id'),
                'business_team_members_id' => request('business_team_members_id'),
                'appointment_date' => request('appointment_date'),
                'appointment_time' => request('appointment_time'),
                'note' => request('note'),
                'recurring_appointment' => request('recurring_appointment'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $bookAppointment = BusinessAppointment::createAppointment($instArray);

           

            if($bookAppointment)
            {
                $userName = User::select('name')->where('id',$bookAppointment->user_id)->first();
                $teamMember = BusinessTeamMember::select('name')->where('id',$bookAppointment->business_team_members_id)->first();
                $dateTime = $bookAppointment->appointment_date.' '.$bookAppointment->appointment_time;
                $businessName = Business::select('name')->where('id',$bookAppointment->business_id)->first();

               

                $detailsArray = [
                    'sender_id' => $bookAppointment->business_id,
                    'receiver_id' => auth()->user()->id,
                    'title' => "Appointment Booked",
                    'message'=>"You have booked an appointment with ".$businessName->name." on  ".$dateTime,
                    'appointment_id'=>$bookAppointment->id,
                    'notification_type'=>2,
                ];
                $message = "You have booked an appointment with ".$businessName->name." on  ".$dateTime;
                $title = "Appointment Booked";
                Notification::createNotification($detailsArray);

                $NotificationData =  array('message' => $message, 'body' => 'Mark as unread', "title" => $title, "appointment_id" => $bookAppointment->id);
                if (!empty(auth()->user()->device_token)) {
                    NotificationHelper::pushToGoogle(array(auth()->user()->device_token), $NotificationData);
                }


            }
            $businessDetails = Business::findBusiness(request('business_id'));
            if (!empty($businessDetails)) {
                $totalAppointment = $businessDetails->numbers_of_appointment - 1;

                Business::where('id', request('business_id'))->update(array('numbers_of_appointment' => $totalAppointment, 'updated_at' => date('Y-m-d H:i:s')));
            }
            if ($bookAppointment) {
                return response()->json(['error_msg' => 'Book Appointment Successfully', 'status' => 1, 'data' => array("appointment_id" => $bookAppointment->id)], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Please try again', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function getFaqList()
    {
        $faqList = Faq::getAllFaq();
        if (count($faqList) != 0) {
            return response()->json(['error_msg' => 'FAQ List', 'status' => 1, 'data' => array($faqList)], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No FAQ List', 'status' => 0, 'data' => array()], $this->successStatus);
        }
    }

    public function aboutUs()
    {
        $data['cmsData'] = Cms::findCms(1);
        echo view('api.cms', $data);
    }
    public function privacyPolicy()
    {
        $data['cmsData'] = Cms::findCms(2);
        echo view('api.cms', $data);
    }
    public function termsConditions()
    {
        $data['cmsData'] = Cms::findCms(3);
        echo view('api.cms', $data);
    }

    public function addUserCardDetails(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name_of_card' => 'required',
            'card_number' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvc' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        }
            try {
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $token = $stripe->tokens->create([
                    'card' => [
                        'number' => $request->card_number,
                        'exp_month' => $request->exp_month,
                        'exp_year' => $request->exp_year,
                        'cvc' => $request->cvc,
                    ],
                ]);
            } catch (\Stripe\Exception\CardException $e) {
                return response()->json(['error_msg' => $e->getError()->message, 'data' => array(), 'status' => 0], $this->successStatus);
            }

                if (!empty($token)) {
                    $customer = \Stripe\Customer::create(array(
                        'name' => $request->name_of_card,
                        'email' => $user['email'],
                        'source' => $token->id
                    ));

                    if (!empty($customer)) {

                        // $insert = $this->userRepository->storeUsercardDetail($request->name_of_card, $customer->id, $customer);
                        $instArray = array('user_id' => $user->id, 'name_of_card' => $request->name_of_card, 'stripe_customer_id' => $customer->id, 'customer_json' => $customer);
                        $insert = UserCardDetails::createUserCardDetails($instArray);
                        return response()->json(['error_msg' => 'Card added successfully.', 'status' => 1, 'data' => array($insert)], $this->successStatus);
                    } else {
                        return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                    }
                } else {
                    return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                }
    }

    public function getUserCardList()
    {
        $user = auth()->user();
        $getUserCarddata = UserCardDetails::getUserCardDetailsList($user['id']);
        $mainarray = array();
        if (count($getUserCarddata) > 0) {
            foreach ($getUserCarddata as $ckey) {
                $cust_id = $ckey->stripe_customer_id;
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $customer = $stripe->customers->retrieve(
                    $cust_id,
                    []
                );

                $customer_detail = $stripe->customers->retrieveSource(
                    $customer->id,
                    $customer->default_source
                );

                $ckey->last4 = $customer_detail['last4'];
                $ckey->brand = $customer_detail['brand'];
                $ckey->exp_month = $customer_detail['exp_month'];
                $ckey->exp_year = $customer_detail['exp_year'];
                $mainarray[] = $ckey;
            }
        }
        if (!empty($mainarray)) {
            return response()->json(['error_msg' => 'Card list.', 'status' => 1, 'data' => $mainarray], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }

    public function getAppointmentList()
    {
        $user = Auth::user();
        $listData = BusinessAppointment::allAppointmentList($user->id);
        foreach ($listData as $value) {
            $getPrice = ProductWiseTeamMember::where('business_sub_services_id', $value->business_sub_services_id)->where('team_member_id', $value->business_team_members_id)->first();
            if (!empty($getPrice)) {
                $value->price = $getPrice->price;
            } else {
                $value->price = 0;
            }

            if($value->appointment_status == 'Confirm')
            {
                $value->appointment_status = 'Confirmed';
            }
            elseif($value->appointment_status == 'Cancel')
            {
                $value->appointment_status = 'Cancelled';
            }
            elseif($value->appointment_status == 'Complete')
            {
                $value->appointment_status = 'Completed';
            }
            else{
                $value->appointment_status = 'Pending';
            }
        }
        if (count($listData) != 0) {
            return response()->json(['error_msg' => 'Appointment List', 'status' => 1, 'data' => $listData], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No Appointment List', 'status' => 0, 'data' => array()], $this->successStatus);
        }
    }

    public function editAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id'    => 'required',
            'business_id'    => 'required',
            'business_services_id'    => 'required',
            'business_sub_services_id'    => 'required',
            'business_team_members_id'    => 'required',
            'appointment_date'    => 'required',
            'appointment_time'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $user = Auth::user();
            $updateArray = array(
                'business_id' => request('business_id'),
                'business_services_id' => request('business_services_id'),
                'business_sub_services_id' => request('business_sub_services_id'),
                'business_team_members_id' => request('business_team_members_id'),
                'appointment_date' => request('appointment_date'),
                'appointment_time' => request('appointment_time'),
                'note' => request('note'),
                'recurring_appointment' => request('recurring_appointment'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $bookAppointment = BusinessAppointment::updateAppointment(request('appointment_id'), $updateArray);

            $getAppointmentData = BusinessAppointment::where('id',$request->appointment_id)->first();
            $userName = User::select('name')->where('id',$getAppointmentData->user_id)->first();
            $dateTime = $getAppointmentData->appointment_date.' '.$getAppointmentData->appointment_time;
            $businessName = Business::select('name')->where('id',$getAppointmentData->business_id)->first();

            $details = [
                'sender_id' => auth()->user()->id,
                'receiver_id' => $getAppointmentData->business_id,
                'title' => $userName->name." had changed an appointment with ".$businessName->name." on ".$dateTime,
                'message'=>'Mark as unread',
                'appointment_id'=>$getAppointmentData->id,
                'notification_type'=>12,
            ];
            Notification::createNotification($details);

            $detailsArray = [
                'sender_id' => $getAppointmentData->business_id,
                'receiver_id' => auth()->user()->id,
                'title' => "Appointment Changed",
                'message'=> "You had changed an appointment with ".$businessName->name." on ".$dateTime,
                'appointment_id'=>$getAppointmentData->id,
                'notification_type'=>11,
            ];
            $message = "You had changed an appointment with ".$businessName->name." on ".$dateTime;
            $title = "Appointment Changed";
            Notification::createNotification($detailsArray);

            $NotificationData =  array('message' => $message, 'body' => 'Mark as unread', "title" => $title, "appointment_id" => $getAppointmentData->id);
            if (!empty($user->device_token)) {
                NotificationHelper::pushToGoogle(array($user->device_token), $NotificationData);
            }

            if ($bookAppointment) {
                return response()->json(['error_msg' => 'Update Appointment Successfully', 'status' => 1, 'data' => array()], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Please try again', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function cancelAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id'    => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $user = Auth::user();
            $updateArray = array(
                'appointment_status' => 'Cancel',
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $bookAppointment = BusinessAppointment::updateAppointment(request('appointment_id'), $updateArray);

            $getAppointmentData = BusinessAppointment::where('id',$request->appointment_id)->first();
            $userName = User::select('name')->where('id',$getAppointmentData->user_id)->first();
            $dateTime = $getAppointmentData->appointment_date.' '.$getAppointmentData->appointment_time;
            $businessName = Business::select('name')->where('id',$getAppointmentData->business_id)->first();

            $details = [
                'sender_id' => auth()->user()->id,
                'receiver_id' => $getAppointmentData->business_id,
                'title' => $userName->name." had cancelled an appointment with ".$businessName->name." on ".$dateTime,
                'message'=>'Mark as unread',
                'appointment_id'=>$getAppointmentData->id,
                'notification_type'=>10,
            ];
            Notification::createNotification($details);

            $detailsArray = [
                'sender_id' => $getAppointmentData->business_id,
                'receiver_id' => auth()->user()->id,
                'title' => "Appointment Cancelled",
                'message'=>"You had cancelled an appointment with ".$businessName->name." on ".$dateTime,
                'appointment_id'=>$getAppointmentData->id,
                'notification_type'=>9,
            ];
            $message = "You had cancelled an appointment with ".$businessName->name." on ".$dateTime;
            $title = "Appointment Cancelled";
            Notification::createNotification($detailsArray);

            $NotificationData =  array('message' => $message, 'body' => 'Mark as unread', "title" => $title, "appointment_id" => $getAppointmentData->id);
            if (!empty(auth()->user()->device_token)) {
                NotificationHelper::pushToGoogle(array(auth()->user()->device_token), $NotificationData);
            }

            if ($bookAppointment) {
                return response()->json(['error_msg' => 'Cancel Appointment Successfully', 'status' => 1, 'data' => array()], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Please try again', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function getNotificationList()
    {
        $user = Auth::user();
        $listData = Notification::getNotificationList($user->id);
        if (count($listData) != 0) {
            return response()->json(['error_msg' => 'Notification List', 'status' => 1, 'data' => $listData], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No Notification List', 'status' => 0, 'data' => array()], $this->successStatus);
        }
    }

    public function appointmentPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_id'    => 'required',
            'appointment_id'    => 'required',
            'sub_services_id'    => 'required',
            'card_id'    => 'required',
            'service_amount'   => 'required',
            'team_member_amount'   => 'required',
            'total_amount'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $user = Auth::user();
            $business=Business::findBusiness($request->business_id);
           
            $randomNo = substr(str_shuffle("0123456789"), 0, 4);
            $order_number = date('Ymdhis') . $randomNo;
            $getCustomerstripID = UserCardDetails::where('id', $request->card_id)->whereNull('deleted_at')->first();
            if (!$getCustomerstripID) {
                return '0';
            }
            if(!empty($business->secret_key))
            {
               $key =  Stripe\Stripe::setApiKey($business->secret_key);
                
            }else{
                
                $key = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            }
           
            $currency = "GBP";
            $itemNumber = $order_number;
            $itemPrice = $request->total_amount * 100;
            $charge = \Stripe\Charge::create(array(
                'customer' => $getCustomerstripID->stripe_customer_id,
                'amount' => $itemPrice,
                'currency' => $currency,
                'description' => $itemNumber,
                'metadata' => array(
                    'item_id' => $itemNumber
                )
            ));
            $chargeJson = $charge->jsonSerialize();
            if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1 && $chargeJson['status'] == 'succeeded') {
                $insertArray = array(
                    'user_id' => $user['id'],
                    'appointment_id' => $request->appointment_id,
                    'business_id' => $request->business_id,
                    'sub_services_id' => $request->sub_services_id,
                    'card_id' => $request->card_id,
                    'order_type' => $request->order_type,
                    'service_amount' => $request->service_amount,
                    'team_member_amount' => $request->team_member_amount,
                    'total_amount' => $request->total_amount,
                    'order_number' => $order_number,
                    'payment_json' => json_encode($chargeJson),
                    'created_at' => date('Y-m-d H:i:s'),
                    'discount_id' => $request->discount_id,
                    'coupon_code' => $request->coupon_code,
                    'discount_amount' => $request->discount_amount,

                );
                $insert = AppointmentPayment::createAppointmentPayment($insertArray);
                // $updateArray = array(
                //     'appointment_status' => 'Confirm',
                //     'updated_at' => date('Y-m-d H:i:s'),
                // );
                // $bookAppointment = BusinessAppointment::updateAppointment($request->appointment_id, $updateArray);
                
                $bookAppointment = BusinessAppointment::where('id',$request->appointment_id)->first();
                $userName = User::select('name')->where('id',$bookAppointment->user_id)->first();
                $teamMember = BusinessTeamMember::select('name')->where('id',$bookAppointment->business_team_members_id)->first();
                $dateTime = $bookAppointment->appointment_date.' '.$bookAppointment->appointment_time;
                $businessName = Business::select('name')->where('id',$bookAppointment->business_id)->first();

                $getPaymentData = AppointmentPayment::where('appointment_id',$request->appointment_id)->orderBy('id','desc')->first();
                if($getPaymentData){
                    $details = [
                        'sender_id' => auth()->user()->id,
                        'receiver_id' => $bookAppointment->business_id,
                        'title' => $userName->name." has booked appointment with ".$teamMember->name." on  ".$dateTime,
                        'message'=>'Mark as unread',
                        'appointment_id'=>$bookAppointment->id,
                        'notification_type'=>1,
                    ];

                    Notification::createNotification($details);
                }

               
                $dateOfAppointment = BusinessAppointment::select('appointment_date')->where('id',$request->appointment_id)->first();
                $location = Business::select('name')->where('id',$request->business_id)->first();


                $details = array('booking'=>$insert->order_number,'date'=>$dateOfAppointment->appointment_date,'location'=>$location->name);

                return response()->json(['error_msg' => 'Appointment Payment Successfully', 'status' => 1, 'data' => $details], $this->successStatus);
            }
        }
    }

    public function getTeammemberListBusinessSubServiceWise(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_sub_services_id'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $user = Auth::user();
            $businessSubServicesId = request('business_sub_services_id');

            $listData = ProductWiseTeamMember::getTeamMemberListAPI($businessSubServicesId);
            if (count($listData) != 0) {
                return response()->json(['error_msg' => 'getTeammemberListBusinessSubServiceWise List', 'status' => 1, 'data' => $listData], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'No getTeammemberListBusinessSubServiceWise List', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function getTeammemberTimeSlotList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teammember_id'    => 'required',
        ]);

        $teamMemberDate = strtotime($request->date);
        $day = date('l', $teamMemberDate);

        //$currentTime = date("H:i");
       

        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $user = Auth::user();
            $teamMemberId = request('teammember_id');

            $getAppointmentTime = BusinessAppointment::where('business_team_members_id',$teamMemberId)->where('appointment_date',$request->date)->get();
         
            $listData = '';
            if(count($getAppointmentTime))
            {
                foreach($getAppointmentTime as $data)
                {
                    $listData = BusinessTeamMemberTimeSlot::getTeammemberTimeSlotList($teamMemberId,$day, $data->appointment_time);
                }  
            }
            else{
                $listData = BusinessTeamMemberTimeSlot::getTeammemberTimeSlotList($teamMemberId,$day);
            }
           
            $bookedTimeSlotList = BusinessAppointment::getAppointmentTeamMemberWise($teamMemberId);

          
            $main = $listData;
            if ($listData) {
                return response()->json(['error_msg' => 'Team member Time Slot List', 'status' => 1, 'data' => $main], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'No Team member Time Slot List', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function getBusinessOffersList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_id'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $user = Auth::user();
            $businessId = request('business_id');

            $listData = BusinessOffer::getOfferBusinessWise($businessId);
            if (count($listData) != 0) {
                return response()->json(['error_msg' => 'Offer Business Wise List', 'status' => 1, 'data' => $listData], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'No Offer Business Wise List', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }

    public function updateDeviceToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $user = Auth::user();
            $updateProfile = User::updateUser($user->id, ['device_token' =>
            $request->device_token,'updated_at'=>now()]);
            if ($updateProfile) {
                return response()->json(['error_msg' => 'Token updated successfully.', 'data' => array(), 'status' => 1], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'social_id' => 'required',
            'social_type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $getUser = User::where('social_id', '=', request('social_id'))->first();
            
            if (!empty($getUser)) {
                $user =  Auth::guard('web')->user();
               
                $userarray = array('token' => $getUser->createToken('MyApp')->plainTextToken);
                User::where('id', $getUser->id)->update($userarray);
                $user = User::find($getUser->id);
                return response()->json(['error_msg' => 'Login successfully.', 'status' => 1, 'data' => array($user)], $this->successStatus);
            } else {
                $input = $request->all();
                $user = User::create($input);
                $user = User::find($getUser->id);
                $token = $user->createToken('MyApp')->accessToken;
                $userarray = array('token' => $token);
                $user['token'] = $token;
                User::where('id', $user->id)->update($userarray);

                if($user){
                    return response()->json(['error_msg' => 'Successfully Registered.', 'status' => 1, 'data' => array($user)], $this->successStatus);
                } else {
                    return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                }
            }
        }
    }

    public function checkOffer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_id' => 'required',
            'offer_code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $user = Auth::user();
            $getOffers = BusinessOffer::checkOffer(request('business_id'), request('offer_code'));
            if ($getOffers) {
                return response()->json(['error_msg' => 'Offers is valid.', 'data' => array($getOffers), 'status' => 1], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Offers is not valid.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }


    public function getAppointmentById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $user = Auth::user();
            $appointmentId = request('appointment_id');
            $appointment = BusinessAppointment::getAppointmentsById($appointmentId);

            if ($appointment) {
                return response()->json(['error_msg' => 'Appointment Detail', 'status' => 1, 'data' => array($appointment)], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Appointment Not Found', 'status' => 0, 'data' => array()], $this->successStatus);
            }
        }
    }


    public function testCronJob(Request $request)
    {

        echo "test";
    }

    public function testNotification(Request $request)
    {
				$title = "Just a reminder";
				$message = "Test You have an upcoming appointment at";
                $getDriverToken = User::findUser($request->id);

		$NotificationData =  array('message' => $message, 'body' => $message, "title" => $title);
		if (!empty($getDriverToken->device_token)) {
			NotificationHelper::pushToGoogle(array($getDriverToken->device_token), $NotificationData);
		}
    }
    public function logout(Request $request)
	{
		    $user = Auth::user();
            $getUser = User::where('id', '=', $user['id'])->first();
            if(!empty($getUser)){
            $getUser->tokens->each(function ($token, $key) {
                $token->delete();
            });
            return response()->json(['error_msg' => 'Logout.', 'status' => 1, 'data' => array()], $this->successStatus);
        }

	}
    public static function getAppointmentByIdBusiness(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_msg' => $validator->errors()->all()[0], 'status' => 0, 'data' => array()], $this->successStatus);
        } else {
            $user = Auth::user();
            $appointmentId = request('appointment_id');
            $appointment = BusinessAppointment::getAppointmentsByIdBusiness($appointmentId);

            if($appointment->appointment_status == 'Confirm')
            {
                $appointment->appointment_status = 'Confirmed';
            }
            elseif($appointment->appointment_status == 'Cancel')
            {
                $appointment->appointment_status = 'Cancelled';
            }
            elseif($appointment->appointment_status == 'Complete')
            {
                $appointment->appointment_status = 'Completed';
            }
            else{
                $appointment->appointment_status = 'Pending';
            }

            if ($appointment) {
                return response()->json(['error_msg' => 'Appointment Detail', 'status' => 1, 'data' => array($appointment)]);
            } else {
                return response()->json(['error_msg' => 'Appointment Not Found', 'status' => 0, 'data' => array()]);
            }
        }
    }

}
