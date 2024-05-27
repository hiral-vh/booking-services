<?php
namespace App\Http\Traits;
use Mail;

trait MailSendTrait{
    public function sendMail($email_message,$email,$subject){
    	$data = array('email'=>$email,'subject'=>$subject,'msg'=>$email_message);
		try {
    	Mail::send([], [], function ($message) use ($data){
		  $message->to($data['email']);
          $message->subject($data['subject']);
          $message->setBody($data['msg'], 'text/html'); // for HTML rich messages
		});
			return  '1';
		}catch(Exception $e) {
			return $e;
    	}
    }
}
