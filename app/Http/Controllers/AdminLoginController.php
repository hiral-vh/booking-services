<?php

namespace App\Http\Controllers;

use App\Helpers\AttachMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Http\traits\MailSendTrait;
use App\Login;
use App\LoginLog;
use URL;


class AdminLoginController extends Controller {

    use MailSendTrait;

    public function __construct() {

    }

    public function index() {
        $session = Session::get('admin_login');
        if ($session == '' || $session == null) {
            return view('admin_login');
        } else {
            return redirect('dashboard');
        }
    }

    public function login(Request $request) {
        $customMessages = [
            'user_name.required' => 'The email address field is required.',
            'password.required' => 'The password field is required'
        ];
        $rules = [
            'user_name' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return redirect("login")
                            ->withErrors($validator, 'login')
                            ->withInput();
        } else {
            $email = Input::post('user_name');

            $password = Input::post('password');

            $user = Login::checkUserLogin($email, $password);
            if (!empty($user)) {
                $data = array(
                    "id" => $user->id,
                    "name" => $user->first_name . ' ' . $user->last_name,
                    'photo' => $user->photo,
                    'email' => $user->email,
                    'mobile' => $user->mobile
                );
                Session::put('user', $user);
                Session::put('admin_login', $data);
                Session::put('login_id', $user->id);

                // Track User Login
                $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $page = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";

                if (!empty($_SERVER['QUERY_STRING'])) {
                    $page = $_SERVER['QUERY_STRING'];
                } else {
                    $page = "";
                }
                  $useragent = $_SERVER['HTTP_USER_AGENT'];
                  $remotehost = @getHostByAddr($ipaddress);
             $user_info = json_encode(array("Ip" => $ipaddress, "Page" => $page, "UserAgent" => $useragent, "RemoteHost" => $remotehost));
                if (!empty($_POST)) {
                    $user_post_data = $_POST;
                } else {
                    $user_post_data = array();
                }
                $user_fk = getallheaders();
                if (empty($user_fk)) {
                    $user_fk = array();
                }
                $log_array = array(
                  'admin_fk'=>  $user->id,
                    'login_date'=>date('Y-m-d H:i:s'),
                    'browser_details'=> $user_info
                );
                $insert = new LoginLog($log_array);
                $insert->save();
                return redirect("dashboard")->with(array("success" => "You have been successfully logged in"));
            } else {
                Session::flash('error', 'Invalid email or password');
                return redirect()->route('login')->with('error', 'Invalid email or password')->withInput();
            }
        }
    }

    public function forgot_password(Request $request) {
        if ($request->session()->get('admin_login')) {
            Session::flash('error', 'Already Logged in!!, Please Logout and try again.');
            return redirect("/dashboard");
        } else {
            return view("forgot_password");
        }
    }

    public function reset_password(Request $request) {
        $validator = Validator::make($request->all(), [
                    'username' => [function ($attribute, $username, $fail) {
                            $attribute = "";
                            if ($username == "") {
                                $attribute .= 'Please enter Email.';
                            }
                            if ($attribute != "") {
                                $fail($attribute);
                            }
                        },
                    ],
        ]);
        if ($validator->fails()) {
            return redirect("/forgot_password")
                            ->withErrors($validator, 'forgot_password')
                            ->withInput();
        } else {
            $username = strtolower(Input::post('username'));
            $arrResult = Login::get_admin_by_email($username);
            if ($arrResult == "") {
                Session::flash('error', 'Your account was not found, please try again');
                return redirect()->route('forgot-password')->withInput();
            } else {
                $newPW = substr(uniqid(mt_rand(), true), 0, 6);
                $userID = $arrResult['id'];
                $sql = Login::where("id", $userID)->update(array("rs" => $newPW));
                $html = '<html><head>
                <style>
                    #messagebody
                    {
                        margin-left:20px;margin-right:40px;margin-bottom:100px;line-height:24px;font-size:14px;
                    }
                </style>
                </head>
                <body>
                    <div id="messagebody">
                        Hello ' . $arrResult["first_name"] . ' ' . $arrResult["last_name"] . ',<br /><br />We have received your password reset request.  To reset your password <a href="' . URL::to("/") . '/check_code?code=' . $newPW . '"> <strong>Click Here</strong></a>.
                        <br /></br />
                        Thank you,
                    </div>
                </body>
                </html>';

                $mail = $this->sendMail($html,$arrResult->email,'Reset Password');
                if($mail)
                {
                    Session::flash('success', 'We have sent you mail for reset your password ');
                    return redirect("/login");
                }else{
                    Session::flash('error', 'Mail not sent.');
                    return redirect("/login");
                }

            }
        }
    }

    public function check_code() {
        $this->data['code'] = $code = Input::post('code');
        $check_code = Login::checkCode($code);
        if ($check_code != NULL) {
            return view("reset_password",$this->data);
        } else {
            abort(404);
        }
    }

    public function reset_pass(Request $request) {
        $code = Input::get('code');
        $validator = Validator::make($request->all(), [
                    'password' => [function ($attribute, $password, $fail) {
                            $attribute = "";
                            if ($password == "") {
                                $attribute .= 'Please enter Password';
                            }
                            if ($attribute != "") {
                                $fail($attribute);
                            }
                        },
                    ],
                    're_password' => [function ($attribute, $re_pass, $fail) {
                            $attribute = "";
                            if ($re_pass == "") {
                                $attribute .= 'Please enter Re-Type Password';
                            }
                            if ($attribute != "") {
                                $fail($attribute);
                            }
                        },
                    ],
        ]);
        if ($validator->fails()) {
            return redirect("/check_code?code=$code")
                            ->withErrors($validator, 'reset_pass')
                            ->withInput();
        } else {
            $password = Input::post('password');
            $re_password = Input::post('re_password');
            $code = Input::get('code');
            $arrResult = Login::get_user_by_code($code);
            if ($arrResult == "") {
                Session::flash('error', 'Your account was not found, please try again');
                return redirect("/check_code?=$code");
            } else {
                $userID = $arrResult['id'];
                $sql = Login::where("id", $userID)->update(array("rs" => null,"password" => md5($re_password)));
                Session::flash('success', 'Your password successfully changed');
                return redirect("/login");
            }
        }
    }

    public function logout() {
        Session::forget('user');
        Session::forget('admin_login');
        Session::forget('login_id');
        Session::flash('success', 'You have been successfully logged out');
        return redirect('/login');
    }

    public function duplicate_email(Request $request) {
        $session = Session::get('admin_login');
        if ($session == '') {
            return redirect('admin_login');
        } else {
            $id = Input::post('id');
            $email = Input::post('email');

            $query = Login::check_duplicate($email, $id);
            if ($query < 1) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

}
