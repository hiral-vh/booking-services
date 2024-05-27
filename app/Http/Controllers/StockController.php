<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\StockMaster;
use App\AdminProductMaster;
use URL;
use Yajra\Datatables\Datatables;
use App\Helpers\SlugHelper;
use PDF;

class StockController extends Controller
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
        return view('stock_master/stock_list', $this->data);
    }
   /*Customer List Page*/
    public function add() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
			$this->data['product_list']=AdminProductMaster::productList(); 
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('stock_master/stock_add', $this->data);
    }
   /*Customer Insert*/
    public function insert(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
				$this->data['admin_login'] = $admin_login = Session::get('admin_login');
          
		  
		         $stockavailable = StockMaster::getRecordByproductId(Input::post('product'));
				 $product_data = AdminProductMaster::editRecordById(Input::post('product'));
			 	 $product_quantity= $product_data->inner_quantity;
				 
				
				 if($stockavailable)
				 {
					 $avalstk = $stockavailable->available_stock;
					
					 $quantity_type = Input::post('quantity');
					 
					 
					 if(Input::post('quantity_type') == 'box_quantity')
					 {
						 $new_stock = $product_quantity * $quantity_type;
						 $available_stock = $avalstk + $new_stock;
					 }
					 else
					 {
						 $new_stock = Input::post('quantity');
						 $available_stock = $avalstk + $new_stock;
					 }
				 }
		  
		        else
				{
					 $quantity_type = Input::post('quantity');
					 if(Input::post('quantity_type') == 'box_quantity')
					 {
						
						 $available_stock = $product_quantity * $quantity_type;
					 }
					 else
					 {
						 $available_stock = Input::post('quantity');
					 }
				}
		  
                $data_array = array(
                    'product_id' => Input::post('product'),
					'quantity_type'=>Input::post('quantity_type'),
					'quantity'=>Input::post('quantity'),
					'available_stock'=>$available_stock,
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $admin_login['id']
                );
                $insert = new StockMaster($data_array);
                $insert->save();
                $update = $insert->id;


                if ($update) {
                    Session::flash('success', "Stock successfully inserted.");
                    return redirect('stock');
                } else {
                    Session::flash('error', 'Sorry, something went wrong. Please try again.');
                    return redirect('stock-add');
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
			$this->data['product_list']=AdminProductMaster::productList(); 
            $this->data['stock_data'] = StockMaster::editRecordById($id);
        }
        return view('stock_master/stock_edit', $this->data);
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
                'product' => 'required',
				'quantity_type' => 'required',
				'quantity' => 'required'
			
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return redirect("Stock-edit?id=" . Input::post('id'))
                                ->withErrors($validator, 'Stock')
                                ->withInput();
            } else {
				
				
				 $stockavailable = StockMaster::getRecordByproductId(Input::post('product'));
				 $product_data = AdminProductMaster::editRecordById(Input::post('product'));
			 	 $product_quantity= $product_data->inner_quantity;
				 
				
					 $avalstk = $stockavailable->available_stock;
					 
					 $quantity_type = Input::post('quantity');
					 if(Input::post('quantity_type') == 'box_quantity')
					 {
						 $new_stock = $product_quantity * $quantity_type;
						 $available_stock = $avalstk + $new_stock;
					 }
					 else
					 {
						 $new_stock = Input::post('quantity');
						 $available_stock = $avalstk + $new_stock;
					 }
				 
		  
		        
				
                $data_array = array(
                    'product_id' => Input::post('product'),
					'quantity_type'=>Input::post('quantity_type'),
					'quantity'=>Input::post('quantity'),
					'available_stock'=>$available_stock,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $admin_login['id']
                );
                
                $update = StockMaster::where('id', $stockavailable->id)->update($data_array);
                Session::flash('success', 'Stock updated successfully.');
                return redirect('/stock');
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
            $update = StockMaster::where('id', $id)->update(array('deleted_flag' => 'Y', 'deleted_date' => date('Y-m-d H:i:s'), 'deleted_by' => $admin_login['id']));
            if ($update) {
                Session::flash('success', "Stock successfully deleted.");
                return redirect('stock');
            } else {
                Session::flash('error', 'Sorry, something went wrong. Please try again.');
                return redirect('stock');
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
            $stock = StockMaster::stockList();
            $n =1;
            foreach($stock as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($stock)
                            /* ->addColumn('Action', function ($stock) {
                                $conf = "'Are you sure to delete the detail permanently?'";
                                $action = '<a href="stock-edit?id='.$stock->id.'"><i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i></a><a href="javascript:void(0);" onclick="deleteswal('.$stock->id.');"><i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a> <a href="#"><i style="margin-left: 15px;" class="icon feather icon-eye f-w-600 f-16 m-r-15 text-c-green" data-toggle="modal"></i></a>';
                                return $action;
                            }) */
                            ->editColumn('product_name', function ($stock) {
                                $c_name = $stock->product_name;
                                return $c_name;
                            })
							 ->editColumn('quantity_type', function ($stock) {
								 if($stock->quantity_type == 'box_quantity')
								 {
									 $quantity_type = 'Box Quantity';
								 }
								 else{
									 $quantity_type = 'Quantity';
								 }
                                $q_name = $quantity_type;
                                return $q_name;
                            })
                            ->rawColumns(['product_name', 'quantity_type'])
                            ->make(true);
        }
    }
	
	/*Customer List Page*/
    public function Availablestock() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
        }
        return view('available_stock/available_stock_list', $this->data);
    }
	
	
   /*Customer List Page*/
   public function Available_stock_ajax_list() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            /* $stock = StockMaster::AvalilablestockList(); */
			
			$stock = AdminProductMaster::productList();
			foreach ($stock as $data) {

				$available_stock=StockMaster::getRecordByproductId($data->id);
				if($available_stock)
				{
				$data['available_stock'] = $available_stock->available_stock;
				}
				else{
					$data['available_stock'] = 0;
				}
			}
			
            $n =1;
            foreach($stock as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($stock)
                            
                            ->editColumn('product_name', function ($stock) {
                                $c_name = $stock->name;
                                return $c_name;
                            })
							 
                            ->rawColumns(['product_name'])
                            ->make(true);
        }
    }
	
	
	
	
	function Available_stockCSV(Request $request)
	{
	
	$headers = array(
			"Content-type" => "text/csv",
			"Content-Disposition" => "attachment; filename=available_stock.csv",
			"Pragma" => "no-cache",
			"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
			"Expires" => "0"
		);
          $stock = AdminProductMaster::productList();
			foreach ($stock as $data) {

				$available_stock=StockMaster::getRecordByproductId($data->id);
				if($available_stock)
				{
				$data['available_stock'] = $available_stock->available_stock;
				}
				else{
					$data['available_stock'] = 0;
				}
			}

		$columns = array('Product Name', 'Category Name', 'Available Stock');
	
		$callback = function() use ($stock, $columns)
		{
			$file = fopen('php://output', 'w');
			fputcsv($file, $columns);

			foreach($stock as $export_data) {
				fputcsv($file, array($export_data->name, $export_data->category, $export_data->available_stock,));
			}
			fclose($file);
		};
		
		return Response()->stream($callback, 200, $headers);
		}
		
		
		
		public function Available_stockPDF() {
			
			$stock = AdminProductMaster::productList();
			foreach ($stock as $data) {

				$available_stock=StockMaster::getRecordByproductId($data->id);
				if($available_stock)
				{
				$data['available_stock'] = $available_stock->available_stock;
				}
				else{
					$data['available_stock'] = 0;
				}
			}
			$data['report'] = $stock;
        
		    $pdf = PDF::loadView('pdf.available_stock', $data);
            $pdf->save(storage_path().'_filename.pdf');
            return $pdf->download('Available_stock.pdf');
		    
		}

	
}
