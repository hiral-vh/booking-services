<?php

namespace App\Http\Controllers\business;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\ImageUploadTrait;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Notification;
use App\Models\SiteSetting;
use Validator;
class BusinessProfileController extends Controller
{
    use ImageUploadTrait;

    public function rules ($id=0) {
		return array_merge(
			[
                'first_name'   => 'required|max:25',
                'last_name'    => 'required|max:25',
				'email'        => 'required|email|max:100|unique:business_users,email'.($id?",$id,id":''),
                'apk_link'     => 'max:255',
                'ipa_link'     => 'max:255',
                'public_key'   => 'required',
                'secret_key'   => 'required',
			],
        );
	}

    public function List()
    {
        $data['business']=$business=Auth::guard('business_user')->user();
        $data['businessOwner']=Business::findBusiness($business->business_id);
        $data['sitesetting']=SiteSetting::getSiteSettings();
        $data['module']='Business Profile '.'Details ';
        return view('business.business-profile',$data);
    }

    public function update(Request $request)
    {
        $id=Auth::guard('business_user')->user()->id;
        $businessId=Auth::guard('business_user')->user()->business_id;
        $updatedata = array(
            'name' => $request->first_name.' '.$request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'updated_at'=>now(),
            'updated_by'=>$id,
        );

        \Stripe\Stripe::setApiKey($request->secret_key);
        $updateBusinessData = '';
        try {
        // create a test customer to see if the provided secret key is valid
            $updateBusinessData = \Stripe\Customer::create(["description" => "Test Customer - Validate Secret Key"]);
        }catch(\Exception $e) {
            Session::flash('error', 'Invalid secret key provided');
            return redirect()->back();
        }

        $updateBusinessData = array(
            'public_key' => $request->public_key,
            'secret_key' => $request->secret_key,
            'updated_at'=>now(),
            'updated_by'=>$id,
        );

        $updateLinkData=array(
            "apk_link"=>$request->apk_link,
            "ipa_link"=>$request->ipa_link,
        );

        $businessOwner=Business::updateBusiness($businessId,$updateBusinessData);

        $validator = Validator::make($request->all(),$this->rules($id));

        if ($validator->fails()) {
            return redirect('business-profile')->withErrors($validator,"admin")->withInput();
        }else{

            $updateLink=SiteSetting::updateSiteSettings($updateLinkData);

            $file_name = '';
                if ($request->hasFile('image') ) {
                    $file_name=$this->uploadImage($request->image,'business/images/user/');
                }

                if($file_name != ''){
                    $updatedata['profile_image'] = $file_name;
                }

            $update=BusinessUser::updateUser($id,$updatedata);

            if ($update) {
                Session::flash('success', 'Profile '.trans('messages.updatedSuccessfully'));
                return redirect()->back();
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }
    }

    public function getNotifications(Request $request)
    {
        $notification=Notification::getNotificationListByBusinessId($request->business_id);
        
        return response()->json(['notifications'=>$notification]);
    }

    public function getWebNotifications(Request $request)
    {
        $getWebnotification = Notification::getWebNotifyNotification($request->business_id);
        if($getWebnotification){
                $icon = 'assets/images/favicon.ico';
                self::sendNotification($getWebnotification->id,$request->business_id,$getWebnotification->title,$getWebnotification->message,$icon);
                $update = Notification::where('id', $getWebnotification->id)->where('receiver_id',$request->business_id)->update(array('web_notify' => '1'));
        }
        return response()->json(['webNotifications'=>$getWebnotification]);
    }
    

    public function sendNotification($id,$businessId,$title,$body,$icon)
    {

        $firebaseToken = Business::where('id',$business_id)->whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'AAAAjhKuxnA:APA91bFPRpLrVNOnw522ilcme2Sd5N30SGN4Rg4mWsLpztQywBD24ahkqrvJwkHtcuY4EhgTMWUjfMpfqyp8r793WTL4kbSqVqkGDAbHkzhnxcA58igTrMHSz0Vt6bGrnzF_nCPmeJZe';


        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $title,
                "body" => $body,
                "icon" => $icon,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        return $response;
    }
    public function markAsReadNotificationById(Request $request)
    {
      
        $user=Auth::guard('business_user')->user();
        $notification=Notification::updateNotification($request->notification_id,['is_read'=>1]);
        $getNotification=Notification::getNotificationListByBusinessId($user->business_id);
        $getNotificationCount = Notification::where('receiver_id',$user->business_id)->where('is_read',null)->count();
        if(count($getNotification) > 0)
        {
            return response()->json(['status'=>1,'notification'=>$getNotification,'data'=>$getNotificationCount]);
        }else{
            return response()->json(['status'=>0]);
        }

    }


}
