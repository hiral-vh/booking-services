<?php



namespace App\Helpers;



use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;

use Mail;



class MailHelper {

	

	public static function mail_send($email_message,$email,$subject){

		

		$data = array('email'=>$email,'subject'=>$subject,'msg'=>$email_message);

		try {

		Mail::send([], [], function ($message) use ($data){

		  $message->to($data['email']);

		   $message->subject($data['subject']);

			// here comes what you want

			// or:

			$message->setBody($data['msg'], 'text/html'); // for HTML rich messages

		});

			return  '1';

		}catch(Exception $e) {

				return $e;

		}

		/*

		$data = array('email'=>$email,'subject'=>$subject);

		Mail::raw($email_message, function ($message) use ($data){

		$message->to($data['email']);

		$message->subject($data['subject']);

		});

		*/

	}

}