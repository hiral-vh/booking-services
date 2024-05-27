<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\MailSendTrait;
use App\Helpers\MailHelper;
use Illuminate\Http\Request;
use App\Models\Admin;
use Validator;
use Crypt;
use URL;

class ForgotPasswordController extends Controller
{
    use MailSendTrait;

    public function list()
    {
        $this->data['module'] = 'Forgot Password';
        return view('auth.forgot-password', $this->data);
    }

    /*  public function checkEmail(Request $request)
    {
        $userEmail = Admin::getUserByEmail($request->email);

        if ($userEmail) {
            return response()->json(['message' => 'exist']);
        } else {
            return response()->json(['message' => 'not_exist']);
        }
    } */

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email'

        ]);

        if ($validator->fails()) {
            return redirect("forgot-password")
                ->withErrors($validator, 'password.reset')
                ->withInput();
        } else {
            $email = request('email');
            $checkEmail = Admin::getByEmail($email);

            if ($checkEmail) {

                $string = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
                $rand =  substr(str_shuffle($string), 0, 8);
                $encrypted = Crypt::encrypt($rand);

                $subject = "Booking Services Reset Password";


                $email_message = '

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">



<head>

   <meta name="viewport" content="width=device-width" />

   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

   <title>MunchCadet Reset Password</title>

</head>



<body style="margin:0px; background: #f8f8f8; ">

   <div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">

       <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">

           <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">

               <tbody>

                   <tr>

                   <td style="vertical-align: middle; margin-bottom:30px; text-align:center;"> <img src="' . url('/') . '/uploads/site_settings/Icon.png" alt="logo" style="background-color:#fbcb01;"></td>

                   </tr>

               </tbody>

           </table>

           <div style="padding: 40px; background: #fff;">

               <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">

                   <tbody>

                       <tr>

                           <td style="border-bottom:1px solid #f6f6f6;">

                               <h1 style="font-size:14px; font-family:arial; margin:0px; font-weight:bold;">Dear ' . ucfirst($checkEmail->name) . ',</h1>

                               <p style="margin-top:0px; color:#bbbbbb;">Here are your password reset instructions.</p>

                           </td>

                       </tr>

                       <tr>

                           <td style="padding:10px 0 30px 0;">

                               <p>A request to reset your Admin password has been made. If you did not make this request, simply ignore this email. If you did make this request, please reset your password</p>

                               <center>

                                   <a href="' . URL::to('reset-password-view/' . $encrypted) . '" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #1b2a4e; border-radius: 60px; text-decoration:none;">Reset Password</a></br>

                               </center>

                               <b>- Thanks (Booking Services Team)</b> </td>

                       </tr>



                   </tbody>

               </table>

           </div>



       </div>

   </div>

</body>

</html>';

                $mail = MailHelper::mail_send($email_message, $email, $subject);
                $data = array('otp' => $rand, 'updated_at' => date('Y-m-d h:i:s'));
                $update = Admin::where('id', $checkEmail->id)->update($data);
                if ($update) {
                    Session::flash('success', 'Email send successfully');
                    return redirect('admin-login');
                }
            } else {
                Session::flash('error', 'There isn’t any account associated with this email');
                return redirect('/admin-forgot-password');
            }
        }
    }


    public function resetPasswordView(Request $request, $otp)
    {

        $this->data['title'] = "Reset Password";

        $this->data['otp'] = $otp;

        $otpDecrypt = Crypt::decrypt($otp);

        $checkOtp = Admin::getByOTP($otpDecrypt);

        if (!empty($checkOtp)) {
            return view('auth.reset-password', $this->data);
        } else {
            return view('auth.reset-password', $this->data);
        }
    }

    public function resetPassword(Request $request, $otp)
    {

        $otp = Crypt::decrypt($otp);
        $password = Hash::make($request->new_password);


        $updatedata = array(
            'password' => $password,
            'otp' => null,
            'updated_at' => now(),
        );

        $update = Admin::updateAdmin($otp, $updatedata);

        if (isset($update)) {
            Session::flash('success', 'Password ' . trans('messages.updatedSuccessfully'));
            return redirect()->route('admin-login');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect()->back();
        }
    }
    public function checkEmail(Request $request)
    {
        $userEmail = Admin::where('email', $request->email)->first();

        if ($userEmail) {
            return response()->json(['message' => 'exist']);
        } else {
            return response()->json(['message' => 'not_exist']);
        }
    }
}
