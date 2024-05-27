<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Notification;
use App\DeviceToken;
use App\Helpers\WorkAssignHelper;
use Auth;
use Mail;

class NotificationHelper
{
    public static function pushToGoogle($arrayAndroidToken, $NotificationData)
    {
        $googleApiKey = 'AAAAgF9CjaU:APA91bGN_G6l7o0bX8tkkaAW0vSpa2Dvd32W7HfQz24ZufCm8sWwcEOy7AYXm3qSBvXT5_TwjZQnEpT-cJYc2HuueMiAD2-rdeCET9ZjjFFAIS11FXVJNAe7tiM4ElfEIbDiDQuzI2JG';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $arrayAndroidToken,
            'data' => $NotificationData,
            'priority' => 'high',
            'notification' => $NotificationData,
        );
        $headers = array(
            'Authorization: key=' . $googleApiKey,
            'Content-Type: application/json',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);


        curl_close($ch);
        return $result;
    }
}
