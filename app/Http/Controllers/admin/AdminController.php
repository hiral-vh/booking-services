<?php

namespace App\Http\Controllers\admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\ImageUploadTrait;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;

class AdminController extends Controller
{
    use ImageUploadTrait;
    public function rules () {
		return array_merge(
			[
                'name'     => 'required|max:255',
				'email'    => 'required|email|unique:admins,email',
                'password' => 'required|min:8|max:15',
                'confirmPassword'=>'required|same:password',
                'profileImage' => 'mimes:jpeg,jpg,png,svg',
			],
        );
	}
    public function rules1 ($id) {
		return array_merge(
			[
                'name'     => 'required|max:255',
				'email'    => 'required|email|unique:admins,email'.($id ? ",$id,id" : ''),
                'profileImage' => 'mimes:jpeg,jpg,png,svg',
			],
        );
	}
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index(Request $request)
    {
        $user=Auth::guard('admin')->user();
        $this->data['module']='Admin '.'List ';
        if(!empty($request->name))
        {
            $this->data['admin']=Admin::getAdminByNameOrEmail($request->name,'',$user->id);
        }else if(!empty($request->email)){
            $this->data['admin']=Admin::getAdminByNameOrEmail('',$request->email,$user->id);
        }
        else
        {
            $this->data['admin']=Admin::getAdminByNameOrEmail('','',$user->id);
        }
        return view('admin.admin.index',$this->data);
    }

    public function create()
    {
        $this->data['module']='Admin '.'Add ';
        return view('admin.admin.create',$this->data);
    }

    public function store(Request $request)
    {
        $password=Hash::make($request->password);
        $createAdmin=([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$password,
            "created_at"=>now(),
            "created_by"=>Auth::user()->id,
        ]);

        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect('admin-create')->withErrors($validator,"admin")->withInput();
        }else{

            $file_name = '';
                if ($request->hasFile('profileImage') ) {
                    $file = $request->file('profileImage');
                    $file_name=$this->uploadImage($file,'assets/images/admin/');
                }

                if($file_name != ''){
                    $createAdmin['profile_image'] = $file_name;
                }

            $admin=Admin::storeAdmin($createAdmin);

            if($admin)
            {
                Session::flash('success', 'Admin '.trans('messages.createdSuccessfully'));
                return redirect('admin');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('admin');
            }
        }
    }

    public function show(Admin $admin)
    {

    }


    public function edit($id)
    {
        $this->data['module']='Admin '.'Edit ';
        $this->data['admin']=Admin::findAdmin($id);
        return view('admin.admin.edit',$this->data);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),$this->rules1($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator,"admin")->withInput();
        }else{

            $updateAdmin=([
                "name"=>$request->name,
                "email"=>$request->email,
                "updated_at"=>now(),
                "updated_by"=>Auth::user()->id,
            ]);

            $file_name = '';
            if ($request->hasFile('profileImage') ) {
                $file = $request->file('profileImage');
                $file_name=$this->uploadImage($file,'assets/images/admin/');
            }

            if($file_name != ''){
                $updateAdmin['profile_image'] = $file_name;
            }


            $admin=Admin::updateAdmin($id,$updateAdmin);

            if($admin)
            {
                Session::flash('success', 'Admin '.trans('messages.updatedSuccessfully'));
                return redirect('admin');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('admin');
            }
        }
    }

    public function destroy($id)
    {
        $admin=Admin::deleteAdmin($id);

        if($admin)
            {
                Session::flash('success', 'Admin '.trans('messages.deletedSuccessfully'));
                return redirect('admin');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect('admin');
            }

    }

    public function checkEmail(Request $request)
    {
        $check=Admin::checkEmail($request->email,$request->id,$request->oldPassword);

        if(!empty($check))
        {
            return response()->json(1);
        }
        else
        {
            return response()->json(0);
        }
    }
    public function checkPassword(Request $request)
    {
        $password=Admin::findAdmin($request->id)->password;

        if (Hash::check($request->oldPassword,$password)) {
			return response()->json(1);
		} else {
            return response()->json(0);
		}

    }

    public function updateAdminStatus(Request $request)
    {
            $adminUpdateStatus = Admin::findAdmin($request->id);
            $st = $adminUpdateStatus->status==1?0:1;
            $adminUpdateStatus->update(["status"=>$st]);
            return $st;
    }

}
