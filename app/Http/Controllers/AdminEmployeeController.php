<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\AdminEmployeeMaster;
use URL;
use Yajra\Datatables\Datatables;
use App\Helpers\SlugHelper;

class AdminEmployeeController extends Controller
{
    public function __construct() {
        $session = Session::get('admin_login');

        if ($session == '' || $session ==null) {
            return redirect('login');
        }
    }
    /*Employee List Page*/
    public function index() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('employee_master/employee_list', $this->data);
    }
   /*Employee List Page*/
    public function add() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['employee_code'] = AdminEmployeeMaster::lastEmployeeCode();
        }
        return view('employee_master/employee_add', $this->data);
    }
   /*Employee Insert*/
    public function insert(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'city' => 'required',
                        'date_of_birth' => 'required',
                        'address' => 'required',
                        'posal_code' => 'required',
                        'contact' => 'required',
						'email_id' => 'required|email',
						'password' => 'required',
						'file_img'=>'mimes:jpeg,jpg,png,gif'
            ]);
            if ($validator->fails()) {
                return redirect("/employee-add")
                                ->withErrors($validator, 'Employee')
                                ->withInput();
            } else {
                 $slug =SlugHelper::slug(Input::post('name'),'mf_employee_master', $field = 'slug', $key = NULL, $value = NULL);
				 /* $employee_code = AdminEmployeeMaster::checkEmployeeCode(Input::post('employee_code')); */
				if($request->file('file_img') !=''){
                    $image = $request->file('file_img');
                    $photo = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/employee');
                    $image->move($destinationPath, $photo);
                }
                $data_array = array(
                    'employee_code' => Input::post('employee_code'),
                    'name' => Input::post('name'),
                    'date_of_birth' => Input::post('date_of_birth'),
                    'city' => Input::post('city'),
					'address'=>Input::post('address'),
					'posal_code'=>Input::post('posal_code'),
					'email_id'=>Input::post('email_id'),
					'password'=>md5(Input::post('password')),
					'contact'=>Input::post('contact'),
					'image' => $photo,
					'notes'=>Input::post('notes'),
                    'slug' => $slug,
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $admin_login['id']
                );
                $insert = new AdminEmployeeMaster($data_array);
                $insert->save();
                $update = $insert->id;


                if ($update) {
                    Session::flash('success', "employee successfully inserted.");
                    return redirect('employee');
                } else {
                    Session::flash('error', 'Sorry, something went wrong. Please try again.');
                    return redirect('employee-add');
                }
            }
        }
    }
    /*Employee Edit Page*/
    public function edit(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $this->data['employee_data'] = AdminEmployeeMaster::editRecordById($id);
        }
        return view('employee_master/employee_edit', $this->data);
    }
  /*Employee Update*/
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
                'city' => 'required',
                'date_of_birth' => 'required',
				'address' => 'required',
				'posal_code' => 'required',
				'contact' => 'required',
				'email_id' => 'required|email'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return redirect("employee-edit?id=" . Input::post('id'))
                                ->withErrors($validator, 'Employee')
                                ->withInput();
            } else {
				if(Input::post('password'))
				{
					$password = Input::post('password');
				}
				else
				{
					$password=Input::post('old_password');
				}
				if($request->file('file_img') !=''){
                    $image = $request->file('file_img');
                    $photo = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/employee');
                    $image->move($destinationPath, $photo);
                }else{
                    $photo = Input::post('old_img');
                }
                $data_array = array(
                    'name' => Input::post('name'),
                    'city' => Input::post('city'),
                    'date_of_birth' => Input::post('date_of_birth'),
					'address'=>Input::post('address'),
					'posal_code'=>Input::post('posal_code'),
					'email_id'=>Input::post('email_id'),
					'password'=>md5($password) ,
					'contact'=>Input::post('contact'),
					'image' => $photo,
					'notes'=>Input::post('notes'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $admin_login['id']
                );
                
                if(Input::post('name') != Input::post('old_value')){
                     $slug =SlugHelper::slug(Input::post('name'),'mf_employee_master', $field = 'slug', $key = NULL, $value = NULL);
                     $data_array['slug'] = $slug;
                }
                
                $update = AdminEmployeeMaster::where('id', Input::post('id'))->update($data_array);
                Session::flash('success', 'Employee updated successfully.');
                return redirect('/employee');
            }
        }
    }
    /*Employee Delete*/
    public function delete(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $update = AdminEmployeeMaster::where('id', $id)->update(array('deleted_flag' => 'Y', 'deleted_date' => date('Y-m-d H:i:s'), 'deleted_by' => $admin_login['id']));
            if ($update) {
                Session::flash('success', "Employee successfully deleted.");
                return redirect('employee');
            } else {
                Session::flash('error', 'Sorry, something went wrong. Please try again.');
                return redirect('employee');
            }
        }
    }
   /*Employee List Ajax*/
    public function ajax_list() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $employee = AdminEmployeeMaster::employeeList();
            $n =1;
            foreach($employee as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($employee)
                            ->addColumn('Action', function ($employee) {
                                $active_status = "";
                                if($employee->active_status == 1){
									$active_status =  '<i class="fa fa-thumbs-o-down"></i>';
								}else{
									$active_status =  '<i class="fa fa-thumbs-o-up"></i>';
								}
								
                                $conf = "'Are you sure to delete the detail permanently?'";
                                $action = '<a href="employee-edit?id='.$employee->id.'"><i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i></a><a href="javascript:void(0);" onclick="deleteswal('.$employee->id.');"><i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a> <a style="font-size: 17px;margin-left: 8px;color:#4099ff" onclick="statusswal('.$employee->id.');" >'.$active_status.'</a>';
                                return $action;
                            })
                            ->editColumn('name', function ($employee) {
                                $c_name = $employee->name;
                                return $c_name;
                            })
                            ->editColumn('Status', function ($employee) {
								if($employee->active_status ==1){
									$status = '<label class="label label-success" onclick="statusswal('.$employee->id.');">approved</label>';	
								}else{
									$status = '<label class="label label-danger" onclick="statusswal('.$employee->id.');">Pending</label>';
								}
								return $status;
							})
                            ->rawColumns(['name','Status','Action'])
                            ->make(true);
        }
    }
	/*Check Exit Email*/
	public function check_employee_email(Request $request){
       
         
		 $query = AdminEmployeeMaster::where('email_id','=',Input::post('email_id'))->where('deleted_flag','=','N')->first();
		 
         if(!empty($query)){
             echo 0;
         }else{
             echo 1;
         }
        
   }
   
   /*Check Exit Email For Edit*/
   public function check_employee_email_in_edit(Request $request){
       
        
		 $query = AdminEmployeeMaster::where('email_id','=',Input::post('email_id'))->where('deleted_flag','=','N')->first();
		
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
   public function Status(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
			$active_status = AdminEmployeeMaster::editRecordById($id);
			
			
			if($active_status->active_status == 1)
			{	
				$update = AdminEmployeeMaster::where('id', $id)->update(array('active_status' => 0));
			}
			else
			{
				$update = AdminEmployeeMaster::where('id', $id)->update(array('active_status' => 1));
			}
			
            if ($update) {
                Session::flash('success', "Status successfully updated.");
                return redirect('employee');
            } else {
                Session::flash('error', 'Sorry, something went wrong. Please try again.');
                return redirect('employee');
            }
        }
    }
	
	
	
}
