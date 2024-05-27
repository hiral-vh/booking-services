<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Services;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Http\Traits\ImageUploadTrait;

class BusinessUsersController extends Controller
{
    use ImageUploadTrait;

    public function rules () {
		return array_merge(
			[
                'firstName'      => 'required|max:255',
                'lastName'       => 'required|max:255',
				'email'          => 'required|email|unique:business_users,email',
                'password'       => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/',
                'confirmPassword'=> 'required|same:password',
                'businessName'   => 'required|max:255',
                'businessEmail'  => 'required|email|max:255',
                'businessAbout'  => 'required',
                'service'        => 'required',
			],
        );
	}
    public function rules1 ($id) {
		return array_merge(
			[
                'firstName'      => 'required|max:255',
                'lastName'       => 'required|max:255',
				'email'          => 'required|email|unique:business_users,email'.($id ? ",$id,id" : ''),
                'businessName'   => 'required|max:255',
                'businessEmail'  => 'required|email|max:255',
                'businessAbout'  => 'required',
                'service'        => 'required',
			],
        );
	}
    public function __construct()
    {
        $this->data['sitesetting']=SiteSetting::getSiteSettings();
    }

    public function index(Request $request)
    {
        if(!empty($request->userName))
        {
            $this->data['businessUser']=BusinessUser::getUsersByName($request->userName);
        }
        else{
            $this->data['businessUser']=BusinessUser::getBusinessUsersWithPagination();

        }
        $this->data['module']='Business Owners List';
        return view('admin.business-users.index',$this->data);
    }

    public function create()
    {
        $this->data['module']='Business Owners '.'Add ';
        $this->data['service']=Services::listServices();
        return view('admin.business-users.create',$this->data);
    }

    public function store(Request $request)
    {
        $password=Hash::make($request->password);

        $validator = Validator::make($request->all(),$this->rules());

        if ($validator->fails()) {
            return redirect('business-owners/create')->withErrors($validator,"admin")->withInput();
        }else{

            $createBusinessOwner=([
                "service_id"=>$request->service,
                "name"=>$request->businessName,
                "email"=>$request->businessEmail,
                "about"=>$request->businessAbout,
                "created_at"=>now(),
                "created_by"=>Auth::guard('admin')->user()->id,
                "created_by_user_type"=>1,
            ]);

            $businessOwner=Business::createBusiness($createBusinessOwner);

            if(!empty($businessOwner))
            {
                $createUser=([
                    "business_id"=> $businessOwner->id,
                    "first_name"=>$request->firstName,
                    "last_name"=>$request->lastName,
                    "name"=>$request->firstName." ".$request->lastName,
                    "email"=>$request->email,
                    "password"=>$password,
                    "status"=>1,
                    "is_verify"=>1,
                    "created_at"=>now(),
                    "created_by"=>Auth::guard('admin')->user()->id,
                    "created_by_user_type"=>1,
                ]);

                $file_name = '';
                if ($request->hasFile('profileImage') ) {
                    $file = $request->file('profileImage');
                    $file_name=$this->uploadImage($file,'business/images/user/');
                }

                if($file_name != ''){
                    $createUser['profile_image'] = $file_name;
                }

                $user=BusinessUser::createBusinessUser($createUser);
            }
                if($businessOwner)
                {
                    Session::flash('success', 'Business Owner '.trans('messages.createdSuccessfully'));
                    return redirect('business-owners');
                } else {
                    Session::flash('error', trans('messages.errormsg'));
                    return redirect('business-owners');
                }


        }
    }

    public function edit($id)
    {
        $this->data['module']='Business Owners '.'Edit ';
        $this->data['user']=BusinessUser::findUser($id);
        $this->data['service']=Services::listServices();
        return view('admin.business-users.edit',$this->data);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),$this->rules1($id));

        if ($validator->fails()) {
            return redirect('business-owners/'.$id.'/edit')->withErrors($validator,"admin")->withInput();
        }else{
            $updateUser=([
                "first_name"=>$request->firstName,
                "last_name"=>$request->lastName,
                "name"=>$request->firstName." ".$request->lastName,
                "email"=>$request->email,
                "updated_at"=>now(),
                "updated_by"=>Auth::guard('admin')->user()->id,
                "updated_by_user_type"=>1,
            ]);

            $file_name = '';
            if ($request->hasFile('profileImage') ) {
                $file = $request->file('profileImage');
                $file_name=$this->uploadImage($file,'business/images/user/');
            }

            if($file_name != ''){
                $updateUser['profile_image'] = $file_name;
            }

            $user=BusinessUser::updateUser($id,$updateUser);

            if($user)
            {
                $updateBusinessOwner=([
                    "service_id"=>$request->service,
                    "name"=>$request->businessName,
                    "email"=>$request->businessEmail,
                    "about"=>$request->businessAbout,
                    "updated_at"=>now(),
                    "updated_by"=>Auth::guard('admin')->user()->id,
                    "updated_by_user_type"=>1,
                ]);

                $businessOwner=Business::updateBusiness($id,$updateBusinessOwner);

                if($businessOwner)
                {
                    Session::flash('success', 'Business Owner '.trans('messages.updatedSuccessfully'));
                    return redirect('business-owners');
                } else {
                    Session::flash('error', trans('messages.errormsg'));
                    return redirect('business-owners');
                }
            }
        }
    }

    public function destroy($id)
    {
        $user=BusinessUser::find($id)->delete();

        if(!empty($user))
        {
            Session::flash('success', 'Business Owner '.trans('messages.deletedSuccessfully'));
            return redirect('business-owners');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('business-owners');
        }
    }

    public function resetPassword(Request $request)
    {
        $password=Hash::make($request->password);
        $updateUser=([
            "password"=>$password,
            "updated_at"=>now(),
            "updated_by"=>Auth::guard('admin')->user()->id,
            "updated_by_user_type"=>1,
        ]);
        $user=BusinessUser::updateUser($request->user_id,$updateUser);

        if($user)
        {
            Session::flash('success', 'Password '.trans('messages.updatedSuccessfully'));
            return redirect('business-owners');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect('business-owners');
        }
    }

    public function updateUserToggle(Request $request)
    {
            $userUpdateStatus = BusinessUser::findUser($request->id);
            $st = $userUpdateStatus->status==1?0:1;
            $userUpdateStatus->update(["status"=>$st]);
            return $st;
    }

    public function checkBusinessOwnerEmail(Request $request)
    {
        $email=BusinessUser::getUserByEmail($request->email);

        if($email)
        {
            return response()->json(['message'=>'exist']);
        }
        else
        {
            return response()->json(['message'=>'not']);
        }
    }

    public function checkBusinessOwnerEmailWithId(Request $request)
    {
        $emailData=BusinessUser::getUserByEmail($request->email,$request->id);
        if(!empty($emailData))
        {
            return response()->json(['message'=>'exist']);
        }
        else
        {
            return response()->json(['message'=>'not']);
        }
    }

}
