<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Sitesetting;
use URL;
use Yajra\Datatables\Datatables;

class AdminSiteSettingController extends Controller {

    public function __construct() {
        $session = Session::get('admin_login');

        if($session =='' || $session ==null){
            return redirect('login');
        }
    }
    public function index(){
         $session = Session::get('admin_login');

        if($session ==''){
            return redirect('admin');
        }else{
           $this->data['admin_login'] =$admin_login= Session::get('admin_login');
           $this->data['edit_data'] = Sitesetting::sitesettingList();
        }
        return view('site_setting',$this->data);
    }

    public function insert(Request $request){
        $session = Session::get('admin_login');

        if($session ==''){
            return redirect('admin');
        }else{
           $this->data['admin_login'] =$admin_login= Session::get('admin_login');
               $customMessages = [
                'radio.required' => 'The Payment gateway field is required.',
                'sms_mobile.required' => 'The sms mobile number field is required',
                'sms_api.required' => 'The sms api field is required.',
                'sms_screte.required' => 'The sms screte field is required.',

            ];
            $rules = [
                'radio' => 'required',
                'sms_mobile' => 'required',
                'sms_api' => 'required',
                'sms_screte'=>'required'
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {

                return redirect("site_setting")
                                ->withErrors($validator, 'sitesetting')
                                ->withInput();
            }else{
               $data_array =array(
                   'payment_getway'=>Input::post('radio'),
                   'sms_mobile'=>Input::post('sms_mobile'),
                   'sms_api'=>Input::post('sms_api'),
                   'sms_screte'=>Input::post('sms_screte')
               );
               if(Input::post('id') !=''){
                    //$update = Sitesetting::where('id',Input::post('id'))->update($data_array);
                    $sitesetting = Sitesetting::findOrFail($request->id);
                    $sitesetting->payment_getway = Input::post('radio');
                    $sitesetting->sms_mobile = Input::post('sms_mobile');
                    $sitesetting->sms_api = Input::post('sms_api');
                    $sitesetting->sms_screte = Input::post('sms_screte');
                    $sitesetting->save();
                    $update = $sitesetting->id;
                    $smg = "Site setting  successfully updated";
               }else{
                   $insert = new Sitesetting($data_array);
                   $insert->save();
                   $update = $insert->id;
                   $smg = "Site setting successfully inserted";
               }

               if($update){
                   Session::flash('success',$smg);
                   return redirect('site_setting');
               }else{
                   Session::flash('error','Sorry, something went wrong. Please try again.');
                   return redirect('site_setting');
               }
           }
        }
    }

}
