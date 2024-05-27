<?php

namespace App\MyProviders;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;

use App\SiteSettings;

class MailsProvider
{
    static function sendMail($data)
    {
		
		/*$site_settings = SiteSettings::first();
		$footer = $site_settings['footer_text'];
		$footer = str_replace('{{ $year }}',date('Y'),$footer);
		$footer = str_replace('{{ $url }}','javascript:void(0)',$footer);*/
		$logo = asset("user_assets/uploads")."/logo_dark.png";
		
		$data['template']['mail'] = str_replace('{{ $site_title }}',"testing data",$data['template']['mail']);
		
		$data['template']['mail'] = str_replace('{{ $logo }}',$logo,$data['template']['mail']);
		
		$data['template']['mail'] = str_replace('{{ $footer_text }}',"sdfdg",$data['template']['mail']);
			
		$temp = Mail::send('users.emails.global',$data, function($message) use ($data){
				$message->from('shraddha.chauhan@virtualheight.com', 'testing');
				$message->to($data['email']);
				$message->subject($data['template']['subject']);
				$message->setBody($data['template']['mail']);
		});
		$from = $data['template']['from'];
		$headers = "From: $from\r\nReply-To: $from". "\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		$headers .= 'Bcc: shraddha.chauhan@virtualheight.com' . "\r\n";
		
		$mail_sent = @mail($data['email'], $data['template']['subject'], $data['template']['mail'], $headers );
        return $mail_sent ? 1 : 0;
		//print_r($temp);
    }
}