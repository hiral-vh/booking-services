<?php

namespace App\Http\Controllers\admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\ImageUploadTrait;
use App\Models\Business;
use App\Models\BusinessAppointment;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;

class UsersController extends Controller
{
    use ImageUploadTrait;
    public function rules()
    {
        return array_merge(
            [
                'firstName'     => 'required|max:255',
                'lastName'      => 'required|max:255',
                'email'          => 'required|email|unique:users,email',
                'password'       => 'required|min:8|max:15',
                'confirmPassword' => 'required|same:password',
                'mobile'         => 'required',
                // 'country_code'   => 'required',
                'status'        => 'required',
            ],
        );
    }
    public function rules1($id)
    {
        return array_merge(
            [
                'firstName'     => 'required|max:255',
                'lastName'      => 'required|max:255',
                'email'          => 'required|email|unique:users,email' . ($id ? ",$id,id" : ''),
                'mobile'         => 'required',
                // 'country_code'   => 'required',
                'status'        => 'required',
            ],
        );
    }
    public function __construct()
    {
        $this->data['sitesetting'] = SiteSetting::getSiteSettings();
    }

    public function index(Request $request)
    {
        $this->data['userName']=$request->userName;
        $this->data['mobile']=$request->mobile;
        $this->data['email']=$request->email;

        if (!empty($request->userName)) {
            $this->data['users'] = User::getUsersByValue($request->userName,'','');
        }
        if(!empty($request->mobile)){
            $this->data['users'] = User::getUsersByValue('',$request->mobile,'');
        }
        if(!empty($request->email)){
            $this->data['users'] = User::getUsersByValue('','',$request->email);
        }
        if(empty($request->userName) && empty($request->mobile) && empty($request->email))
        {
            $this->data['users'] = User::getUsersPagination();
        }
        $this->data['module'] = 'Business Users ' . 'List ';
        return view('admin.user.index', $this->data);
    }

    public function create()
    {
        $this->data['module'] = 'Business Users ' . 'Add ';
        return view('admin.user.create', $this->data);
    }

    public function store(Request $request)
    {
        $password = Hash::make($request->password);

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect('users/create')->withErrors($validator, "admin")->withInput();
        } else {

            $createUser = ([
                "first_name" => $request->firstName,
                "last_name" => $request->lastName,
                "name" => $request->firstName . " " . $request->lastName,
                "email" => $request->email,
                "mobile" => $request->mobile,
                "password" => $password,
                "status" => $request->status,
                "country_code" => $request->country_code,
                "created_at" => now(),
                "created_by" => Auth::guard('admin')->user()->id,
                "created_by_user_type" => 1,
            ]);

            $file_name = '';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = $this->uploadImage($file, 'assets/images/users/');
            }

            if ($file_name != '') {
                $createUser['profile_photo_path'] = $file_name;
            }

            $user = User::createUser($createUser);

            if ($user) {
                Session::flash('success', 'User ' . trans('messages.createdSuccessfully'));
                return redirect('users');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('users');
            }
        }
    }

    public function edit($id)
    {
        $this->data['module'] = 'Business Users ' . 'Edit ';
        $this->data['user'] = User::findUser($id);
        return view('admin.user.edit', $this->data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules1($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {

            $updateUser = ([
                "first_name" => $request->firstName,
                "last_name" => $request->lastName,
                "name" => $request->firstName . " " . $request->lastName,
                "email" => $request->email,
                "mobile" => $request->mobile,
                "status" => $request->status,
                "country_code" => $request->country_code,
                "updated_at" => now(),
                "updated_by" => Auth::guard('admin')->user()->id,
                "updated_by_user_type" => 1,
            ]);

            $file_name = '';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = $this->uploadImage($file, 'assets/images/users/');
            }

            if ($file_name != '') {
                $updateUser['profile_photo_path'] = $file_name;
            }

            $user = User::updateUser($id, $updateUser);

            if ($user) {
                Session::flash('success', 'User ' . trans('messages.updatedSuccessfully'));
                return redirect('users');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('users');
            }
        }
    }

    public function destroy($id)
    {
        $user = User::deleteUser($id);

        if ($user) {
            Session::flash('success', 'User ' . trans('messages.deletedSuccessfully'));
            return redirect('users');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('users');
        }
    }

    public function resetPassword(Request $request)
    {
        $password = Hash::make($request->password);
        $updateUser = ([
            "password" => $password,
            "updated_at" => now(),
            "updated_by" => Auth::guard('admin')->user()->id,
        ]);
        $user = User::updateUser($request->user_id, $updateUser);
        if ($user) {
            Session::flash('success', 'Password ' . trans('messages.updatedSuccessfully'));
            return redirect('users');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('users');
        }
    }

    public function updateUserToggle(Request $request)
    {
        $userUpdateStatus = User::findUser($request->id);
        $st = $userUpdateStatus->status == 1 ? 0 : 1;
        $userUpdateStatus->update(["status" => $st]);
        return $st;
    }

    public function getUserAddressById($id)
    {
        $userAddress = UserAddress::getUserAddressById($id);

        return response()->json(['address' => $userAddress]);
    }

    public function show($id)
    {
        $this->data['user'] = User::getUserById($id);
        $this->data['module'] = 'Users Show';
        $this->data['appointment']=BusinessAppointment::getTotalAppointmentOfUser($id);
        $this->data['cancelAppointment']=BusinessAppointment::getCancelAppointmentOfUser($id);
        return view('admin.user.show', $this->data);
    }

    public function emailHtml()
    {
        $this->data['user']=Auth::guard('business_user')->user();
        return view('verify-email-business-user',$this->data);
        //return view('verify-business-user',$this->data);
    }
}
