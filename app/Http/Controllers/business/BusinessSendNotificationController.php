<?php

namespace App\Http\Controllers\business;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BusinessSendNotificationController extends Controller
{
    public function index()
    {
        $data['module'] = 'Business Profile ' . 'Details ';
        return view('business.home', $data);
    }
    public function saveToken(Request $request)
    {
      
        $userId =  Auth::guard('business_user')->user()->business_id;
        $update = Business::where('id', $userId)->update(array('device_token' => $request->device_token));
        
        return response()->json(['token saved successfully.']);
    }
    public function sendNotification(Request $request)
    {

        $firebaseToken = Business::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'AAAAjhKuxnA:APA91bFPRpLrVNOnw522ilcme2Sd5N30SGN4Rg4mWsLpztQywBD24ahkqrvJwkHtcuY4EhgTMWUjfMpfqyp8r793WTL4kbSqVqkGDAbHkzhnxcA58igTrMHSz0Vt6bGrnzF_nCPmeJZe';


        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
                "icon" => '{{ asset("assets/images/" . $sitesetting->favicon) }}',
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
}
