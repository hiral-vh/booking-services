<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\ProductOrder;
use App\OrderItems;
use App\NoteMaster;
use App\AdminCategoryMaster;
use App\AdminProductMaster;
use URL;
use Yajra\Datatables\Datatables;
use App\Helpers\SlugHelper;

class AdminOrderController extends Controller
{
    public function __construct() {
        $session = Session::get('admin_login');

        if ($session == '' || $session ==null) {
            return redirect('login');
        }
    }
  /*Product List Page*/
    public function index() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('order/order_list', $this->data);
    }
	public function ajax_list() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
			
			
            $order = ProductOrder::getAllOrderlist();
            $n =1;
            foreach($order as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($order)
                            ->addColumn('Action', function ($order) {
                                $conf = "'Are you sure to delete the detail permanently?'";
                                $action = '<a href="order-edit?id='.$order->id.'"><i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i></a> <a href="order-view?id='.$order->id.'"><i style="margin-left: 15px;" class="icon feather icon-eye f-w-600 f-16 m-r-15 text-c-green" data-toggle="modal"></i></a>';
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
	public function OrderView() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
			
			$id= Input::get('id');
			$this->data['product_order']=ProductOrder::getAlliteamsId($id);
			$this->data['notes']= NoteMaster::GetnoteByemployeeId($this->data['product_order']->id);
			
            /* $this->data['iteams']=OrderItems::getAlliteamsByIdForView($id); */
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('order/order_view', $this->data);
    }
	public function iteam_list_ajax() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
			$id= Input::get('id');
            $order = OrderItems::getAlliteamsByIdForView($id);
            $n =1;
            foreach($order as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($order)
                            
                            ->editColumn('product_name', function ($order) {
                                $e_name = $order->product_name;
                                return $e_name;
                            })
							 ->editColumn('product_price', function ($order) {
                                $c_name = $order->product_price;
                                return $c_name;
                            })
							 ->editColumn('quantity', function ($order) {
                                $q_name = $order->quantity;
                                return $q_name;
                            })
							
                            ->rawColumns(['product_name','product_price', 'Quantity','Action'])
                            ->make(true);
        }
    }
	public function OrderEdit() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
			
			$id= Input::get('id');
			$this->data['product_order']=ProductOrder::getAlliteamsId($id);
			$this->data['notes']= NoteMaster::GetnoteByemployeeId($this->data['product_order']->id);
			$this->data['iteams']=OrderItems::getAlliteamsByIdForView($id); 
			$this->data['product_list']=AdminProductMaster::productList(); 
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('order/order_edit', $this->data);
    }
	
	public function delete(Request $request) {
        $session = Session::get('admin_login');
        $order_id= Input::get('order_id');
        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $this->data['ids'] = $id = Input::get('id');
            $update = OrderItems::where('id', $id)->update(array('deleted_flag' => 'Y', 'deleted_date' => date('Y-m-d H:i:s'), 'deleted_by' => $admin_login['id']));
            if ($update) {
                Session::flash('success', "Product successfully deleted.");
                return redirect('order-edit?id='.$order_id);
            } else {
                Session::flash('error', 'Sorry, something went wrong. Please try again.');
                return redirect('order-edit?id='.$order_id);
            }
        }
    }
	  public function IteamEdit(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
			
			 $id= Input::post('id');
			 $order_id= Input::post('order_id');
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            
			$product_list= Input::post('product_list');
			$price= Input::post('price');
			$quantity= Input::post('quantity');
			
			
			$newfinaltotal= Input::post('newfinaltotal');
			$discount= Input::post('discount');
			$discount_value= Input::post('discount_value');
			
			
			   $discount_array = array(
                    'discount' => $discount,
                    'total' => $newfinaltotal,
                    'discount_value' => $discount_value
                );
                
                $updatearray = ProductOrder::where('id', $order_id)->update($discount_array);
			
			
			
				if($product_list)
				{
					$i=0;
					foreach($product_list as $products_data)
					{
						
						 $product_array = array(
						'product_order_id' => $order_id,
						'product_id' => $products_data,
						'quantity' => $quantity[$i],
						'quantity' => $quantity[$i],
						'created_date' => date('Y-m-d H:i:s'),
						'created_by' => $admin_login['id']
						);
				   
						$insert = new OrderItems($product_array);
						$insert->save();
						$i++; 						
					}
				}
			
			   foreach($id as $id_data)
			   {
				   $data_array = array(
                    'quantity' => Input::post('quantity_'.$id_data),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $admin_login['id']
                );
                
                $update = OrderItems::where('id', $id_data)->update($data_array);
			   }
			
                
                Session::flash('success', 'Product updated successfully.');
                return redirect('order-edit?id='.$order_id);
           
        }
    }
	public function GetPriceById(Request $request) {
        $session = Session::get('event_login');
		 $product=AdminProductMaster::editRecordById($request->product_id);
		
		 echo $product->price;
		}
	 
   
}
