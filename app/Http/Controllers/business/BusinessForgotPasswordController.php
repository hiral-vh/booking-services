<?php

namespace App\Http\Controllers\business;

use App\Models\User;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use App\Models\BusinessUser;
use Illuminate\Http\Request;
use App\Http\Traits\MailSendTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class BusinessForgotPasswordController extends Controller
{
    use MailSendTrait;

    public function rules()
    {
        return array_merge(
            [
                'otp'  => 'required|numeric',
            ],
        );
    }

    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }

    public function List()
    {
        $this->data['module'] = 'Business Forgot Password';
        return view('auth.business.forgot-password', $this->data);
    }

    public function checkEmail(Request $request)
    {
        $userEmail = BusinessUser::getUserByEmail($request->email);

        if ($userEmail) {
            return response()->json(['message' => 'exist']);
        } else {
            return response()->json(['message' => 'not_exist']);
        }
    }

    public function sendLink(Request $request)
    {
        $customToken = array(
            "remember_token"=>Str::random(70),
            "email_verified_at"=>now(),
        );
        BusinessUser::updateUserByEmail($request->email,$customToken);
        $this->data['user']=BusinessUser::getUserByEmail($request->email);
        $html=view('verify-email-business-user',$this->data);
        $email=$this->sendMail($html,$request->email,'Reset Password');
        if($email){
        Session::flash('success', 'Email has been sent successfully please verify');
        return redirect()->back();}else{
            Session::flash('error', 'Email not sent network error');
            return redirect()->back();
        }
    }
    public function checkLink($email,$token)
    {
        $user=BusinessUser::findUserByEmailAndToken($email,$token);
        if(isset($user))
        {
            $this->data['user']=$user;
            return view('auth.business.reset-password',$this->data);
        }else{
            return view('page-404');
        }
    }

    public function resetPassword(Request $request)
    {
        $id = $request->user_id;

        $password = Hash::make($request->new_password);

        $updatedata = array(
            'password' => $password,
            'updated_at'=>now(),
            'updated_by'=>$id,
            'remember_token'=>null,
        );

        $update = BusinessUser::updateUser($id, $updatedata);

        if ($update) {
            Session::flash('success', 'Password ' . trans('messages.updatedSuccessfully'));
            return redirect('business-login');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('business-login');
        }
    }
}
