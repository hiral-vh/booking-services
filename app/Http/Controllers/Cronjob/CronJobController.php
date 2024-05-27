<?php

namespace App\Http\Controllers\Cronjob;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;
use App\Models\Business;
use App\Models\Notification;
use App\Models\BusinessAppointment;
use App\Models\User;
use App\Models\Admin;
use App\Models\Subcription;
use App\Models\BusinessRecurringPaymentHistory;
use Carbon\Carbon;


use Stripe\Stripe;

class CronJobController extends Controller
{

	function getCustomer(){
		$stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
		$customer = $stripe->subscriptions->cancel(
			'sub_1L03LqDhoJZw9YjJEUbatsvo',
			[]
		  );
	
		  
	}

	function sendReminderNotification()
	{
		$getBusinessAppointmentData = BusinessAppointment::listAllAppointment();
		

		foreach ($getBusinessAppointmentData as $value) {
			$hourdiff = round((strtotime($value->appointment_date . ' ' . $value->appointment_time) - strtotime(date('Y-m-d H:i:s'))) / 3600, 1);
			
		
			if ($hourdiff >= '5' || $hourdiff < '6') {
				
				$sender_id = $value->business_id;
				$receiver_id = $value->user_id;
				$title = "Just a reminder";
				$message = "You have an upcoming appointment at  ".$value->business->name .':' .date('D d M Y H:i', strtotime($value->appointment_date . ' ' . $value->appointment_time));
				$notification_type = 1;
				$appointment_id = $value->id;
				$notifications = self::sendNotification($sender_id, $receiver_id, $title, $message, $notification_type, $appointment_id);
				$update = BusinessAppointment::where('id',$value->id)->update(array('notification_send' => '1'));
			}
		}
	}
	function checkResturentsubscription()
	{
		$date = date('Y-m-d');
		$getAllAppointmentdata = Business::whereNull('deleted_at')->where('subscription_flag', '1')->get();
		if (count($getAllAppointmentdata) > 0) {
			foreach ($getAllAppointmentdata as $key) {

				$stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
				$subscriptionData = $stripe->subscriptions->retrieve(
					$key->stripe_subscription_id,
					[]
				);

				if (!empty($subscriptionData)) {
					if ($subscriptionData->cancel_at == '') {
						$current_period_start = date('Y-m-d', $subscriptionData->current_period_start);
						if ($date == $current_period_start) {
							$checkEntryInhistory = BusinessRecurringPaymentHistory::where('business_id', $key->id)->whereRaw('DATE_FORMAT(start_date, "%Y-%m-%d")', date('Y-m-d', $subscriptionData->current_period_start))->whereRaw('DATE_FORMAT(end_date, "%Y-%m-%d")', date('Y-m-d', $subscriptionData->current_period_end))->orderBy('id','DESC')->first();
							if (!empty($checkEntryInhistory)) {
								// update order
								$subscription = Subcription::find($checkEntryInhistory->plan_id);
								$allowed_order = $subscription->allowed_order;

							     Business::where('id', $key->id)->update(array('numbers_of_appointment' => $allowed_order));

								$insertArray = array(
									'business_id' => $key->id,
									'plan_id' => $checkEntryInhistory->plan_id,
									'start_date' => date('Y-m-d H:i:s', $subscriptionData->current_period_start),
									'end_date' => date('Y-m-d H:i:s', $subscriptionData->current_period_end),
									'created_at' => date('Y-m-d H:i:s')
								);
								$insert = new BusinessRecurringPaymentHistory($insertArray);
								$insert->save();
							}
						}
					}
				}
			}
		}
	}

	public function sendOrderNotification()
	{
		
		$getBusiness = Business::getBusinessLessOrders();

		if(count($getBusiness) > 0)
		{
			foreach($getBusiness as $data)
			{
				
				if($data->numbers_of_appointment == 10)
				{
					$getSenderId = Admin::first();
					$sender_id = $getSenderId->id;
					$receiver_id = $data->id;
					$title = "Just a reminder";
					$message = "Dear ".$data->name.", You have used 90% of your free trial. Please subscribe the best plans to continue your access.";
					$notification_type = 5;
					$notifications = self::sendNotification($sender_id, $receiver_id, $title, $message, $notification_type);

				}
			}
		}
		
	}

	public function sendDateNotification()
	{

		
		$data = Business::with('businessRecurringPaymentHistory')->get();
		
		$dateTime = Carbon::now();
		$dateToday = date('Y-m-d', strtotime($dateTime));

		if (count($data) > 0) {
			$date = array();
			foreach ($data as $key=>$rwData) {
				if(count($rwData->businessRecurringPaymentHistory)>0)
				{
					$dates = date('Y-m-d', strtotime($rwData->businessRecurringPaymentHistory[0]->end_date . '-3 days'));
					
					if ($dateToday == $dates) {
						$getSenderId = Admin::first();
						$sender_id = $getSenderId->id;
						$receiver_id = $rwData->id;
						$title = "Just a reminder";
						$message = "Dear ".$rwData->name.", You have used 90% of your free trial. Please subscribe the best plans to continue your access.";
						$notification_type = 6;
						$notifications = self::sendNotification($sender_id, $receiver_id, $title, $message, $notification_type);
					}
				}
			
			}
		}
	}

	public function sendDayBeforeNotification()
	{
		$getBusinessAppointmentData = BusinessAppointment::listAllAppointment();
		

		foreach ($getBusinessAppointmentData as $value) {
			$hourdiff = round((strtotime($value->appointment_date . ' ' . $value->appointment_time) - strtotime(date('Y-m-d H:i:s'))) / 3600, 1);
			
		


			if ($hourdiff >= '24') {
				$sender_id = $value->business_id;
				$receiver_id = $value->user_id;
				$title = "Just a reminder";
				$message = "Remember you have tomorrow an appointment with  ".$value->business->name;
				$notification_type = 11;
				$appointment_id = $value->id;
				$notifications = self::sendNotification($sender_id, $receiver_id, $title, $message, $notification_type, $appointment_id);
				$update = BusinessAppointment::where('id',$value->id)->update(array('notification_send' => '1'));
			}
		}
	}

	public function sendTwentyMinsAgoNotification()
	{
	
		$getBusinessAppointmentData = BusinessAppointment::listAllAppointment();
	
		foreach ($getBusinessAppointmentData as $value) {
			
			$hourdiff = abs((strtotime(date("Y-m-d H:i",strtotime($value->appointment_date . ' ' . $value->appointment_time))) - strtotime(date('Y-m-d H:i'))) / 60);
			
			if ($hourdiff == '20') {
				echo '123';
				$sender_id = $value->business_id;
				$receiver_id = $value->user_id;
				$title = "Just a reminder";
				$message = "Remember you have an appointment with ".$value->business->name." in 20 minutes.";
				$notification_type = 11;
				$appointment_id = $value->id;
				$notifications = self::sendNotification($sender_id, $receiver_id, $title, $message, $notification_type, $appointment_id);
				$update = BusinessAppointment::where('id',$value->id)->update(array('notification_send' => '1'));
			}
		}
	}
	/* API Notification sent */
	public function sendNotification($sender_id, $receiver_id, $title, $message, $notification_type, $appointment_id="")
	{
		$getDriverToken = User::findUser($receiver_id);
		$insarray = array(
			"sender_id" => $sender_id,
			"receiver_id" => $receiver_id,
			"title" => $title,
			"message" => $message,
			"notification_type" => $notification_type,
			"appointment_id" => $appointment_id,
			"created_date" => date('Y-m-d H:i:s')
		);
		Notification::createNotification($insarray);
		$NotificationData =  array('message' => $message, 'body' => $message, "title" => $title, "appointment_id" => $appointment_id);
		if (!empty($getDriverToken->device_token)) {
			NotificationHelper::pushToGoogle(array($getDriverToken->device_token), $NotificationData);
		}
	}
}
