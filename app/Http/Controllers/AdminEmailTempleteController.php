<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\EmailTemplete;
use URL;
use Yajra\Datatables\Datatables;

class AdminEmailTempleteController extends Controller {

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
        }
        return view('email_list',$this->data);
    }
    public function add(){
         $session = Session::get('admin_login');
        if($session ==''){
            return redirect('admin');
        }else{
           $this->data['admin_login'] =$admin_login= Session::get('admin_login');
        }
        return view('email_add',$this->data);
    }

    public function insert(Request $request){
        $session = Session::get('admin_login');
        if($session ==''){
            return redirect('admin');
        }else{
           $this->data['admin_login'] =$admin_login= Session::get('admin_login');
               $customMessages = [
                'title.required' => 'The title field is required.',
                'subject.required' => 'The subject field is required',
                'mail.required' => 'The message field is required.'
            ];
            $rules = [
                'title' => 'required',
                'subject' => 'required',
                'mail' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {

                return redirect("email_add")
                                ->withErrors($validator, 'emailTemp')
                                ->withInput();
            }else{
               $data_array =array(
                 'title'=>Input::post('title'),
                   'subject'=>Input::post('subject'),
                   'mail'=>Input::post('mail'),
                   'created_date'=>date('Y-m-d H:i:s'),
                   'created_by'=>$admin_login['id']
               );
                   $insert = new EmailTemplete($data_array);
                   $insert->save();
                   $update = $insert->id;


               if($update){
                   Session::flash('success',"Email templete successfully inserted.");
                   return redirect('email-list');
               }else{
                   Session::flash('error','Sorry, something went wrong. Please try again.');
                   return redirect('email_add');
               }
           }
        }
    }

    public function edit(Request $request){
         $session = Session::get('admin_login');

        if($session ==''){
            return redirect('admin');
        }else{
           $this->data['admin_login'] =$admin_login= Session::get('admin_login');
           $this->data['ids'] = $id = Input::get('id');
           $this->data['email_data'] = EmailTemplete::editRecordById($id);
         }
        return view('email_edit',$this->data);
    }

    public function update(Request $request){
        $session = Session::get('admin_login');

        if($session ==''){
            return redirect('admin');
        }else{
           $this->data['admin_login'] =$admin_login= Session::get('admin_login');
               $customMessages = [
                'title.required' => 'The title field is required.',
                'subject.required' => 'The subject field is required',
               'mail.required' => 'The message field is required.'
            ];
            $rules = [
                'title' => 'required',
                'subject' => 'required',
                'mail' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {

               return redirect("email_edit?id=".Input::post('id'))
                                ->withErrors($validator, 'emailTemp')
                                ->withInput();
            }else{
               $data_array =array(
                 'title'=>Input::post('title'),
                   'subject'=>Input::post('subject'),
                   'mail'=>Input::post('mail'),
                   'updated_date'=>date('Y-m-d H:i:s'),
                   'updated_by'=>$admin_login['id']
               );
               $update = EmailTemplete::where('id',Input::post('id'))->update($data_array);

               if($update){
                Session::flash('success',"Email templete successfully updated.");
                return redirect('email-list');
                }else{
                    Session::flash('error','Sorry, something went wrong. Please try again.');
                    return redirect('email_edit?id='.Input::post('id'));
                }

           }
        }
    }


    public function delete(Request $request){
         $session = Session::get('admin_login');
        if($session ==''){
            return redirect('admin');
        }else{
           $this->data['admin_login'] =$admin_login= Session::get('admin_login');
           $this->data['ids'] = $id = Input::get('id');
           $update = EmailTemplete::where('id',$id)->update(array('deleted_flag'=>'Y','deleted_date'=>date('Y-m-d H:i:s'),'deleted_by'=>$admin_login['id']));
           if($update){
                    Session::flash('success',"Email templete successfully deleted.");
                   return redirect('email-list');
           }else{
                   Session::flash('error','Sorry, something went wrong. Please try again.');
                   return redirect('email-list');

           }
         }
    }

    public function ajax_list(){
        $session = Session::get('admin_login');

        if($session ==''){
            return redirect('admin');
        }else{
           $this->data['admin_login'] =$admin_login= Session::get('admin_login');
           $ca = EmailTemplete::EmailTempleteList();
            return Datatables::of($ca)
               ->addColumn('Action', function ($ca) {
                   //<a href="javascript:void(0);" onclick="deleteswal('.$ca->id.');"><i class="fas fa-trash-alt delete-icon"></i></a>
                    $action ='<a href="email_edit?id='.$ca->id.'"><i class="fas fa-edit edit-icon"></i></a><a href="email_delete?id='.$ca->id.'"><i class="fas fa-trash-alt delete-icon"></i></a>';
                   return $action;
               })
               ->rawColumns(['Action'])
               ->make(true);
            }
    }

}
