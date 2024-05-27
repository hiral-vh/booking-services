<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\AdminCustomerMaster;
use App\NoteMaster;
use App\ProductOrder;
use URL;
use Yajra\Datatables\Datatables;
use App\Helpers\SlugHelper;

class AdminCustomerController extends Controller
{
    public function __construct() {
        $session = Session::get('admin_login');

        if ($session == '' || $session ==null) {
            return redirect('login');
        }
    }
    /*Customer List Page*/
    public function index() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('customer_master/customer_list', $this->data);
    }
   /*Customer List Page*/
    public function add() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('customer_master/customer_add', $this->data);
    }
   /*Customer Insert*/
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
                return redirect("/customer-add")
                                ->withErrors($validator, 'Customer')
                                ->withInput();
            } else {
                 $slug =SlugHelper::slug(Input::post('name'),'mf_customer_master', $field = 'slug', $key = NULL, $value = NULL);
				 
                $data_array = array(
                    'name' => Input::post('name'),
					'address'=>Input::post('address'),
					'posal_code'=>Input::post('posal_code'),
					'email_id'=>Input::post('email_id'),
					'contact'=>Input::post('contact'),
					'type'=>Input::post('type'),
					'notes'=>Input::post('notes'),
                    'slug' => $slug,
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $admin_login['id']
                );
                $insert = new AdminCustomerMaster($data_array);
                $insert->save();
                $update = $insert->id;


                if ($update) {
                    Session::flash('success', "Customer successfully inserted.");
                    return redirect('customer');
                } else {
                    Session::flash('error', 'Sorry, something went wrong. Please try again.');
                    return redirect('customer-add');
                }
            }
        }
    }
    /*Customer Edit Page*/
    public function edit(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $this->data['customer_data'] = AdminCustomerMaster::editRecordById($id);
        }
        return view('customer_master/customer_edit', $this->data);
    }
  /*Customer Update*/
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
                return redirect("customer-edit?id=" . Input::post('id'))
                                ->withErrors($validator, 'Customer')
                                ->withInput();
            } else {
                $data_array = array(
                    'name' => Input::post('name'),
					'address'=>Input::post('address'),
					'posal_code'=>Input::post('posal_code'),
					'email_id'=>Input::post('email_id'),
					'contact'=>Input::post('contact'),
					'type'=>Input::post('type'),
					'notes'=>Input::post('notes'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $admin_login['id']
                );
                
                if(Input::post('name') != Input::post('old_value')){
                     $slug =SlugHelper::slug(Input::post('name'),'mf_customer_master', $field = 'slug', $key = NULL, $value = NULL);
                     $data_array['slug'] = $slug;
                }
                
                $update = AdminCustomerMaster::where('id', Input::post('id'))->update($data_array);
                Session::flash('success', 'Customer updated successfully.');
                return redirect('/customer');
            }
        }
    }
    /*Customer Delete*/
    public function delete(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $update = AdminCustomerMaster::where('id', $id)->update(array('deleted_flag' => 'Y', 'deleted_date' => date('Y-m-d H:i:s'), 'deleted_by' => $admin_login['id']));
            if ($update) {
                Session::flash('success', "Customer successfully deleted.");
                return redirect('customer');
            } else {
                Session::flash('error', 'Sorry, something went wrong. Please try again.');
                return redirect('customer');
            }
        }
    }
   /*Customer List Ajax*/
    public function ajax_list() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $customer = AdminCustomerMaster::customerList();
            $n =1;
            foreach($customer as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($customer)
                            ->addColumn('Action', function ($customer) {
                                $conf = "'Are you sure to delete the detail permanently?'";
                                $action = '<a href="customer-edit?id='.$customer->id.'"><i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i></a><a href="javascript:void(0);" onclick="deleteswal('.$customer->id.');"><i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a> <a href="customer-view?id='.$customer->id.'"><i style="margin-left: 15px;" class="icon feather icon-eye f-w-600 f-16 m-r-15 text-c-green" data-toggle="modal"></i></a>';
                                return $action;
                            })
                            ->editColumn('name', function ($customer) {
                                $c_name = $customer->name;
                                return $c_name;
                            })
                            ->rawColumns(['name','Action'])
                            ->make(true);
        }
    }
	/*Check Exit Email*/
	public function check_customer_email(Request $request){
       
         
		 $query = AdminCustomerMaster::where('email_id','=',Input::post('email_id'))->where('deleted_flag','=','N')->first();
		 
         if(!empty($query)){
             echo 0;
         }else{
             echo 1;
         }
        
   }
   
   /*Check Exit Email For Edit*/
   public function check_customer_email_in_edit(Request $request){
       
        
		 $query = AdminCustomerMaster::where('email_id','=',Input::post('email_id'))->where('deleted_flag','=','N')->first();
		
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
  /*Customer View Page*/
    public function customer_view() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
			$this->data['ids'] = $id = Input::get('id');
            $this->data['customer_data'] = AdminCustomerMaster::editRecordById($id);
        }
        return view('customer_master/customer_view', $this->data);
    }

	public function OrderAjax(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
			$customer = Input::post('customer_id');
			
            $order = ProductOrder::getAllOrderlistforCustomer($customer);
            $n =1;
            foreach($order as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($order)
                            ->addColumn('Action', function ($order) {
                                $conf = "'Are you sure to delete the detail permanently?'";
                                $action = '<a href="customer-order-view?id='.$order->id.'"><i style="margin-left: 15px;" class="icon feather icon-eye f-w-600 f-16 m-r-15 text-c-green" data-toggle="modal"></i></a>';
                                return $action;
                            })
                            ->editColumn('employee_name', function ($order) {
                                $e_name = $order->employee_name;
                                return $e_name;
                            })
							 ->editColumn('customer_name', function ($order) {
                                $c_name = $order->customer_name;
                                return $c_name;
                            })
							
                            ->rawColumns(['employee_name','customer_name','Action'])
                            ->make(true);
        }
    }	
	public function Orderview() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
			
			$id= Input::get('id');
			$this->data['product_order']=ProductOrder::getAlliteamsId($id);
			$this->data['notes']= NoteMaster::GetnoteByemployeeId($this->data['product_order']->employee_id);
			/* $this->data['iteams']=OrderItems::getAlliteamsByIdForView($id); */
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('customer_master/customer_order_view', $this->data);
    }
	
	
	
}
