<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\StockMaster;
use App\EmployeeStockLog;
use App\AdminEmployeeMaster;
use App\AdminDistributorMaster;
use App\AdminProductMaster;
use URL;
use Yajra\Datatables\Datatables;
use App\Helpers\SlugHelper;
use PDF;

class EmployeeStockLogController extends Controller
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
        return view('employee_stocklog/employee_stock_list', $this->data);
    }
     /*Customer List Ajax*/
    public function ajax_list() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
            $stock = EmployeeStockLog::employeeStockList();
        //    print_r($stock);die;
            $n =1;
            foreach($stock as $c){
                $c->No = $n;
                $n++;
            }
            return Datatables::of($stock)
                          
                        
                            
                             ->editColumn('type', function ($stock) {
                                 if($stock->type == '0')
                                 {
                                     $type = 'Employee';
                                 }
                                 else{
                                     $type = 'Distributor';
                                 }
                                $q_name = $type;
                                return $q_name;
                            })
                             ->editColumn('name', function ($stock) {
                                 if($stock->employee_name != NULL)
                                 {
                                     $name = $stock->employee_name ;
                                     $fk=$stock->employee_fk;
                                 }else if($stock->distributor_name !=NULL){
                                     $name = $stock->distributor_name ;
                                      $fk=$stock->distributor_fk;
                                 }
                               
                                return '<a style="color:blue;"  href="employee_available_stock/'.$stock->type.'/'.$fk.'">'.$name.'</a>';
                            })
                            ->rawColumns(['type','name'])
                            ->make(true);
        }
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
        return view('employee_stocklog/employee_stock_add', $this->data);
    }
    /*Ajax Get Data By Type*/
     public function getDataNameByType() {
       echo  $type = Input::post('type');
        if (isset($type)) {
            if($type==0){
             $DataName = AdminEmployeeMaster::employeeList();   
            }else if($type==1){
             $DataName = AdminDistributorMaster::distributorList();
            }
            echo'<option value="">Select Option</option>';
            foreach ($DataName as $val) {
                echo'<option value="' . $val->id . '">' . $val->name . '</option>';
            }
        } else {
            echo'';
        }
    }

    public function insert(Request $request) {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
				$this->data['admin_login'] = $admin_login = Session::get('admin_login');
          
		      
		      $stockavailable = StockMaster::getRecordByproductId(Input::post('product'));
			 	  $available_stock= $stockavailable->available_stock;
                  $updateId= $stockavailable->id;
                $product_id=Input::post('product');
              $employee_fk=(Input::post('type')==0)?Input::post('name'):NULL;
              $distributor_fk=(Input::post('type')==1)?Input::post('name'):NULL;
             $db_available_quantity=EmployeeStockLog::checkQuantity($product_id,$employee_fk,$distributor_fk);
                 $new_quantity= $db_available_quantity + Input::post('quantity');
            //echo '<pre>';    print_r($new_quantity);die;
                /* if($available_stock >= Input::post('quantity') ){
				         $new_stock= $available_stock - (Input::post('quantity'));
                         $data_array = array(
                            'available_stock'=>$new_stock,
                            'updated_date' => date('Y-m-d H:i:s'),
                            'updated_by' => $admin_login['id']
                        );
                       
                        $updateStock=StockMaster::where('id',$updateId)->update($data_array); }*/
                $data_array = array(
                    'product_id' => Input::post('product'),
					'type'=>Input::post('type'),
					'quantity'=>Input::post('quantity'),
                    'total_quantity'=>$new_quantity,
					'employee_fk'=>$employee_fk,
                    'distributor_fk'=>$distributor_fk,
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $admin_login['id']
                );
            // echo "<pre>";  print_r($data_array);die;
                $insert = new EmployeeStockLog($data_array);
                $insert->save();
                $update = $insert->id;


                if ($update) {
                    Session::flash('success', "Stock successfully inserted.");
                    return redirect('employee-stock');
                } else {
                    Session::flash('error', 'Sorry, something went wrong. Please try again.');
                    return redirect('add-employee-stock');
                }
            
        }
    }
    public function employeeAvailableStockView($type,$fkId) {
          $session = Session::get('admin_login');
           if ($session == '') {
            return redirect('admin');
        } else {
             $this->data['admin_login'] = $admin_login = Session::get('admin_login');
             $this->data['emptype']=$type;
             $this->data['fkId']=$fkId;
            return view('employee_stocklog/employee_available_stock_list', $this->data);
        }
    }

  
    
     public function employeeAvailableStock() {
        $session = Session::get('admin_login');

        if ($session == '') {
            return redirect('admin');
        } else {
            $this->data['admin_login'] = $admin_login = Session::get('admin_login');
             $type=Input::post('status');
             $fkId=Input::post('fkId');
          
           $stock = AdminProductMaster::productList();
          
        //    print_r($stock);die;
            $n =1;
            foreach($stock as $data){
                 $available_employee_stock=EmployeeStockLog::getRecordByEmployeeProductId($data->id,$type,$fkId);
             
                    if($available_employee_stock)
                    {
                      $data->total_quantity = $available_employee_stock->total_quantity;
                    }
                    else{
                         $data->total_quantity = 0;
                    }
                $data->No = $n;
                $n++;
            }
            return Datatables::of($stock)
                            ->make(true);
        }
    }
   
	
}
