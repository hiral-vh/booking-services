<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\AdminDistributorMaster;
use URL;
use Yajra\Datatables\Datatables;
use App\Helpers\SlugHelper;

class AdminDistributorController extends Controller
{
    public function __construct() {
        $session = Session::get('admin_login');

        if ($session == '' || $session ==null) {
            return redirect('login');
        }
    }
  /*Distributor List Page*/
    public function index() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('distributor_master/distributor_list', $this->data);
    }
    /*Distributor Add Page*/
    public function add() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('distributor_master/distributor_add', $this->data);
    }
    /*Distributor Insert*/
    public function insert(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'address' => 'required',
                        'posal_code' => 'required',
                        'contact' => 'required',
						'email_id' => 'required|email'
            ]);
            if ($validator->fails()) {
                return redirect("/distributor-add")
                                ->withErrors($validator, 'Distributor')
                                ->withInput();
            } else {
                 $slug =SlugHelper::slug(Input::post('name'),'mf_distributor_master', $field = 'slug', $key = NULL, $value = NULL);
				
                $data_array = array(
                    'name' => Input::post('name'),
					'address'=>Input::post('address'),
					'posal_code'=>Input::post('posal_code'),
					'email_id'=>Input::post('email_id'),
					'contact'=>Input::post('contact'),
                    'slug' => $slug,
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $admin_login['id']
                );
                $insert = new AdminDistributorMaster($data_array);
                $insert->save();
                $update = $insert->id;


                if ($update) {
                    Session::flash('success', "Distributor successfully inserted.");
                    return redirect('distributor');
                } else {
                    Session::flash('error', 'Sorry, something went wrong. Please try again.');
                    return redirect('distributor-add');
                }
            }
        }
    }
    /*Distributor Edit Page*/
    public function edit(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $this->data['distributor_data'] = AdminDistributorMaster::editRecordById($id);
        }
        return view('distributor_master/distributor_edit', $this->data);
    }
    /*Distributor Update*/
    public function update(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $customMessages = [
                'name.required' => 'Please enter name.',
            ];
            $rules = [
                'name' => 'required',
				'address' => 'required',
				'posal_code' => 'required',
				'contact' => 'required',
				'email_id' => 'required|email'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return redirect("distributor-edit?id=" . Input::post('id'))
                                ->withErrors($validator, 'Distributor')
                                ->withInput();
            } else {
                $data_array = array(
                    'name' => Input::post('name'),
					'address'=>Input::post('address'),
					'posal_code'=>Input::post('posal_code'),
					'email_id'=>Input::post('email_id'),
					'contact'=>Input::post('contact'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $admin_login['id']
                );
                
                if(Input::post('name') != Input::post('old_value')){
                     $slug =SlugHelper::slug(Input::post('name'),'mf_distributor_master', $field = 'slug', $key = NULL, $value = NULL); 
					
                     $data_array['slug'] = $slug;
                }
                
                $update = AdminDistributorMaster::where('id', Input::post('id'))->update($data_array);
                Session::flash('success', 'Distributor updated successfully.');
                return redirect('/distributor');
            }
        }
    }
	/*Distributor Delete*/
    public function delete(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $update = AdminDistributorMaster::where('id', $id)->update(array('deleted_flag' => 'Y', 'deleted_date' => date('Y-m-d H:i:s'), 'deleted_by' => $admin_login['id']));
            if ($update) {
                Session::flash('success', "Distributor successfully deleted.");
                return redirect('distributor');
            } else {
                Session::flash('error', 'Sorry, something went wrong. Please try again.');
                return redirect('distributor');
            }
        }
    }
    /*Distributor Ajax*/
    public function ajax_list() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $distributor = AdminDistributorMaster::distributorList();
            $n =1;
            foreach($distributor as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($distributor)
                            ->addColumn('Action', function ($distributor) {
                                $conf = "'Are you sure to delete the detail permanently?'";
                                $action = '<a href="distributor-edit?id='.$distributor->id.'"><i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i></a><a href="javascript:void(0);" onclick="deleteswal('.$distributor->id.');"><i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a>';
                                return $action;
                            })
                            ->editColumn('name', function ($distributor) {
                                $c_name = $distributor->name;
                                return $c_name;
                            })
                            ->rawColumns(['name','Action'])
                            ->make(true);
        }
    }
   /*Check Exit Email*/
	public function check_distributor_email(Request $request){
       
         
		 $query = AdminDistributorMaster::where('email_id','=',Input::post('email_id'))->where('deleted_flag','=','N')->first();
		 
         if(!empty($query)){
             echo 0;
         }else{
             echo 1;
         }
   }
   
   /*Check Exit Email For Edit*/
   public function check_distributor_email_in_edit(Request $request){
       
        
		 $query = AdminDistributorMaster::where('email_id','=',Input::post('email_id'))->where('deleted_flag','=','N')->first();
		
		 if($query->id == Input::post('id'))
		 {
			 echo 1; 
		 }
		 if($query->id != Input::post('id'))
		 {
			 echo 0; 
		 }
         if(empty($query)){
             echo 1;
         }
        
   } 
	
	
	
}
