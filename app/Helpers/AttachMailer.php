<?php

namespace App\Helpers;
use Mail;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AttachMailer {
    /*
     * @params url du document ajout�
     */

    public static function attachFile($url, $name = "") {
        $documents = array();
        $attachment = chunk_split(base64_encode(file_get_contents($url)));
        //$attachment = chunk_split(base64_encode(get_data($url)));

        $handle = fopen($url, "r");  // set the file handle only for reading the file
        $content = fread($handle, $size); // reading the file
        fclose($handle);                  // close upon completion

        $docName = $name == "" ? basename($url) : $name;
        $randomHash = md5(date('r', time()));
        ;
        $docOutput = "--PHP-alt-$randomHash--\r\n\r\n"
                . "--PHP-mixed-$randomHash\r\n"
                . "Content-Type: application/pdf; name=\"$docName\" \r\n"
                . "Content-Transfer-Encoding: base64 \r\n"
                . "Content-Disposition: attachment \r\n\r\n"
                . $content . "\r\n";
        return $documents = $docOutput;
    }

    public static function addCC($CCEmail) {
        return $cc = $CCEmail;
    }

    public static function get_data($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    private static function makeMessage($message) {
        $documents = array();
        $randomHash = md5(date('r', time()));
        ;
        $messageOutput = "--PHP-mixed-$randomHash\r\n"
                . "Content-Type: multipart/alternative; boundary=PHP-alt-$randomHash\r\n\r\n"
                . "--PHP-alt-$randomHash\r\n"
                . "Content-Type: text/plain; charset='iso-8859-1'\r\n"
                . "Content-Transfer-Encoding: 7bit\r\n\r\n"
                . $message . "\r\n\r\n"
                . "--PHP-alt-$randomHash\r\n"
                . "Content-Type: text/html; charset='iso-8859-1'\r\n"
                . "Content-Transfer-Encoding: 7bit\r\n\r\n"
                . $message . "\r\n";

        foreach ($documents as $document) {
            $messageOutput .= $document;
        }
        $messageOutput .= "--PHP-mixed-$randomHash;--";
        return $messageOutput;
    }

    public static function send12($from, $to, $subject, $message, $url = "", $cc = "") {
        $output = SELF::makeMessage($message);
        //$output="sdfsfs";
        $randomHash = md5(date('r', time()));
        ;
        $headers = "From: $from\r\nReply-To: $from" . "\r\n";
        if ($cc != "") {
            $headers .= 'Cc: ' . $cc . '';
        }
        $headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-$randomHash\"";
        if ($url != "") {
            $headers .= SELF::attachFile($url);
        }
        echo $to;
        //echo $mail_sent=	mail("hiten@virtualheight.com","test","test");
        echo $mail_sent = @mail($to, $subject, $output, $headers);
        return $mail_sent ? 1 : 0;
    }

    public static function send($from, $to, $subject, $message, $url = "", $cc = "") {

        //attachment file path
        //header for sender info
        $headers = "From: $from" . " <" . $from . ">";
        //boundary
        $semi_rand = md5(time());

        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

        //headers for attachment
        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

        //multipart boundary
        $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
        //preparing attachment
        $returnpath="";
        $file = $url;
        if ($url != "") {
            $message .= "--{$mime_boundary}\n";
            $fp = @fopen($file, "rb");
            $data = @fread($fp, filesize($file));

            @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"" . basename($file) . "\"\n" .
                    "Content-Description: " . basename($file) . "\n" .
                    "Content-Disposition: attachment;\n" . " filename=\"" . basename($file) . "\"; size=" . filesize($file) . ";\n" .
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";

            $message .= "--{$mime_boundary}--";
            $returnpath = "-f" . $from;
        }
        //send email
        $mail = @mail($to, $subject, $message, $headers, $returnpath);

        return $mail;
    }

    public static function sendHaPatient($to, $subject, $message, $headers) {
        $mail = @mail($to, $subject, $message, $headers);
        return $mail;
    }



    //********************************************new code********************************************************** */

    public static  function sendMail($email_message,$email,$subject){
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
