<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Login;

class AdminProfileController extends Controller {

    public function __construct() {
        $session = Session::get('admin_login');

        if($session =='' || $session ==null){
            return redirect('login');
        }
    }
    public function index(){
         $session = Session::get('admin_login');

        if($session ==''){
            return redirect()->route('login');
        }else{
           $this->data['admin_login'] =$admin_login= Session::get('admin_login');
           $this->data['edit_data'] =Login::editProfileById($admin_login['id']);
        }
        return view('profile',$this->data);
    }

    public function update_profile(Request $request){
        $session = Session::get('admin_login');
        if($session ==''){
            return redirect()->route('login');
        }else{
           $this->data['admin_login'] = Session::get('admin_login');
           $customMessages = [
                'first_name.required' => 'Please enter first name.',
                'last_name.required' => 'Please enter last name.',
                'email.required' => 'Please enter email address.',
                'mobile.required' => 'Please enter mobile number.'
            ];
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'mobile' => 'required',
                'email' => 'required|email',
                'file_img'=>'mimes:jpeg,jpg,png,bmp'

            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);

            if ($validator->fails()) {

                return redirect("profile")
                                ->withErrors($validator, 'profile')
                                ->withInput();
            } else {
                if($request->file('file_img') !=''){
                    $image = $request->file('file_img');

                    $photo = time().'.'.$image->getClientOriginalExtension();

                    $destinationPath = public_path('/upload/');

                    $image->move($destinationPath, $photo);
                }else{
                    $photo = Input::post('old_img');
                }


                $update_array = array(
                    'first_name' => Input::post('first_name'),
                    'last_name' => Input::post('last_name'),
                    'email' => Input::post('email'),
                    'mobile' => Input::post('mobile'),
                    'address' => Input::post('address'),
                    'photo' => $photo
                );

                $update = Login::where('id',Input::post('id'))->update($update_array);

                Session::forget('admin_login');
                $session_array = array(
                "id" => Input::post('id'),
                "name" => Input::post('first_name').' '.Input::post('last_name'),
                'photo' => $photo,
                'email' => Input::post('email'),
                'mobile'=>Input::post('mobile')
            );

            Session::put('admin_login', $session_array);
                Session::flash('success','Profile successfully updated');
                return redirect('profile');
            }
        }
    }

    public function change_password(Request $request){
        $session = Session::get('admin_login');
        if($session ==''){
            return redirect('admin');
        }else{
           $this->data['admin_login'] =$admin_login= Session::get('admin_login');
           $this->data['edit_data'] =Login::editProfileById($admin_login['id']);
        }
        return view('change_password',$this->data);
    }
    public function update_password(Request $request){
        $session = Session::get('admin_login');
        if($session ==''){
            return redirect('admin');
        }else{
           $this->data['admin_login'] =$admin_login= Session::get('admin_login');

           $customMessages = [
                'old_password.required' => 'Please enter old password.',
                'new_password.required' => 'Please enter new password',
                'confirm_password.required' => 'Please enter confirm password.',

            ];
            $rules = [
                'old_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',

            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);

            if ($validator->fails()) {

                return redirect("change_password")
                                ->withErrors($validator, 'changePassword')
                                ->withInput();
            } else {
                if(Input::post('new_password') == Input::post('confirm_password')){

                    $md5Password = md5($request->new_password);

                    $user = Login::findOrFail($request->id);
                    $user->password = $md5Password;
                    $user->save();
                    Session::flash('success','Password successfully updated.');
                    return redirect('change_password');
              }
            }
        }
    }
/***********************start check old password validation *****************************/
    public function check_oldpassword(Request $request){
       $session = Session::get('admin_login');
        if($session ==''){
            return redirect('admin');
        }else{
         $password = Input::post('old_password');
         $id = Input::post('id');
         $query = Login::CheckOldpassword($id,md5($password));
         if($query)
         {
             return response(['error' => false, 'error-msg' => 'OK'], 200);
         }
         else{
             return response(['error' => true, 'error-msg' => 'Not found'], 404);
         }
        }
   }
/***********************end check old password validation *****************************/
}
