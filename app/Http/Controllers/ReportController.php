<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\ProductOrder;
use App\NoteMaster;
use App\OrderItems;
use App\AdminCategoryMaster;
use App\AdminProductMaster;
use URL;
use Yajra\Datatables\Datatables;
use App\Helpers\SlugHelper;
use PDF;

class ReportController extends Controller
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
			$this->data['product_list']=AdminProductMaster::productList(); 
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('report/report_list', $this->data);
    }
	public function ajax_list() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
			
			
			
			$start_date="";
		   if(Input::get('start_date'))
		   {
			   $start_date=Input::get('start_date');
		   }
		  
		   $end_date="";
		   if(Input::get('end_date'))
		   {
			   $end_date=Input::get('end_date');
		   }
		   $employee_name="";
		   if(Input::get('employee_name'))
		   {
			   $employee_name=Input::get('employee_name');
		   } 
		   $customer_name="";
		   if(Input::get('customer_name'))
		   {
			   $customer_name=Input::get('customer_name');
		   }
		   
		   $product=Input::get('product');
		   
            $order = ProductOrder::getAllreportlist($start_date,$end_date,$employee_name,$customer_name,$product);
			
			
			
            $n =1;
            foreach($order as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($order)
                            ->addColumn('Action', function ($order) {
                                $conf = "'Are you sure to delete the detail permanently?'";
                                $action = '<a href="order-edit?id='.$order->id.'"><i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i></a><a href="report-view?id='.$order->id.'"><i style="margin-left: 15px;" class="icon feather icon-eye f-w-600 f-16 m-r-15 text-c-green" data-toggle="modal"></i></a>';
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
	public function ReportView() {
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
        return view('report/report_view', $this->data);
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
	
	function ExportreportCSV(Request $request)
	{
	
	
	$headers = array(
			"Content-type" => "text/csv",
			"Content-Disposition" => "attachment; filename=file.csv",
			"Pragma" => "no-cache",
			"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
			"Expires" => "0"
		);
           $start_date=Input::get('start_date');
		   $end_date=Input::get('end_date');
		   $employee_name=Input::get('employee_name');
		   $customer_name=Input::get('customer_name');
		   $product=Input::get('product');
		  
		   
		   
            $order = ProductOrder::getAllreportlist($start_date,$end_date,$employee_name,$customer_name,$product);
			
		
			foreach($order as $pdata)
			{
				$iteamdat = OrderItems::getAlliteamsByemployeeId($pdata->id);
				
				$items = array();
				$i=0;
				foreach($iteamdat as $iteamdatdata) {
					$i++;
				
				 
				 $items[] = "(".$i.")"." ".$iteamdatdata->product_name." "." "." "." = "." "." "." ".$iteamdatdata->quantity."\n";
				}

				$pdata->iteamdetail=implode("",$items);
				
			}
			
		$columns = array('Employee Name', 'Customer Name','Product','Total','Discount Value','created_Date');
	
		$callback = function() use ($order, $columns)
		{
			$file = fopen('php://output', 'w');
			fputcsv($file, $columns);

			foreach($order as $export_data) {
				fputcsv($file, array($export_data->employee_name, $export_data->customer_name, $export_data->iteamdetail,$export_data->total,$export_data->discount_value,$export_data->created_date));
			}
			fclose($file);
		};
		
		return Response()->stream($callback, 200, $headers);
		
		}
		
		public function ExportreportPDF() {
			
		   $start_date=Input::get('start_date');
		   $end_date=Input::get('end_date');
		   $employee_name=Input::get('employee_name');
		   $customer_name=Input::get('customer_name');
		   $product=Input::get('product');
		  
		   
		   
            $order = ProductOrder::getAllreportlist($start_date,$end_date,$employee_name,$customer_name,$product);
			
			foreach($order as $pdata)
			{
				$iteamdat = OrderItems::getAlliteamsByemployeeId($pdata->id);
				
				$items = array();
				$i=0;
				foreach($iteamdat as $iteamdatdata) {
					$i++;
				
				 
				 $items[] = "(".$i.")"." ".$iteamdatdata->product_name." "." "." "." = "." "." "." ".$iteamdatdata->quantity."\n";
				}

				$pdata->iteamdetail=implode("",$items);
				
			}
			$data['report']=$order;
        
		    $pdf = PDF::loadView('pdf.report', $data);
            $pdf->save(storage_path().'_filename.pdf');
            return $pdf->download('customers.pdf');
		    
             /*  $view = \View::make('pdf.report', $data);
            $html = $view->render();
			
            PDF::SetTitle('Report PDF');
            PDF::AddPage();
            PDF::writeHTML($html, true, false, true, false, '');

            PDF::Output(); */
    
    }
	
	}
