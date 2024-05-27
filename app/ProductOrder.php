<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductOrder extends Authenticatable
{
	use Notifiable;
	
    public $timestamps = false;
    protected $table = 'mf_product_order';
    protected $fillable = ['id', 'employee_id', 'customer_id', 'discount','discount_value', 'total','deleted_flag', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date'];
	
	/* public static function getAllOrderList(){
		$query = ProductOrder::select('mf_product_order.*','mf_order_items.quantity as quantity','mf_product_master.name as product_name','mf_employee_master.name as employee_name','mf_customer_master.name as customer_name')
                ->leftjoin('mf_order_items',function($join){
                    $join->on('mf_product_order.id','=','mf_order_items.product_order_id');
                     })
					->leftjoin('mf_product_master',function($join){
                    $join->on('mf_order_items.product_id','=','mf_product_master.id');
					$join->where('mf_product_master.deleted_flag','N');
                     })
					 ->leftjoin('mf_employee_master',function($join){
                    $join->on('mf_product_order.employee_id','=','mf_employee_master.id');
					$join->where('mf_employee_master.deleted_flag','N');
                     })
					 ->leftjoin('mf_customer_master',function($join){
                    $join->on('mf_product_order.customer_id','=','mf_customer_master.id');
					$join->where('mf_customer_master.deleted_flag','N');
                     })
					 ->where('mf_product_order.deleted_flag','=',"N")->orderBy('mf_product_order.id','desc')->get();
        return $query;
    }   */
	
	
	/*Get Employee By Id */
	 public static function getAllOrderByemployeeId($id){
		$query = ProductOrder::select('mf_product_order.*','mf_employee_master.name as employee_name','mf_customer_master.name as customer_name')
					 ->leftjoin('mf_employee_master',function($join){
                    $join->on('mf_product_order.employee_id','=','mf_employee_master.id');
					$join->where('mf_employee_master.deleted_flag','N');
                     })
					 ->leftjoin('mf_customer_master',function($join){
                    $join->on('mf_product_order.customer_id','=','mf_customer_master.id');
					$join->where('mf_customer_master.deleted_flag','N');
                     })
					 ->where('mf_product_order.employee_id','=',$id)->where('mf_product_order.deleted_flag','=',"N")->orderBy('mf_product_order.id','desc')->get();
        return $query;
    }  
	
	/*Get Customer By Id*/
	 public static function getAllOrderBycustomerId($id){
		$query = ProductOrder::select('mf_product_order.*','mf_employee_master.name as employee_name','mf_customer_master.name as customer_name')
					 ->leftjoin('mf_employee_master',function($join){
                    $join->on('mf_product_order.employee_id','=','mf_employee_master.id');
					$join->where('mf_employee_master.deleted_flag','N');
                     })
					 ->leftjoin('mf_customer_master',function($join){
                    $join->on('mf_product_order.customer_id','=','mf_customer_master.id');
					$join->where('mf_customer_master.deleted_flag','N');
                     })
					 ->where('mf_product_order.customer_id','=',$id)->where('mf_product_order.deleted_flag','=',"N")->orderBy('mf_product_order.id','desc')->get();
        return $query;
    } 
	
	public static function getAllOrderlist(){
		$query = ProductOrder::select('mf_product_order.*','mf_employee_master.name as employee_name','mf_customer_master.name as customer_name')
					 ->leftjoin('mf_employee_master',function($join){
                    $join->on('mf_product_order.employee_id','=','mf_employee_master.id');
					$join->where('mf_employee_master.deleted_flag','N');
                     })
					 ->leftjoin('mf_customer_master',function($join){
                    $join->on('mf_product_order.customer_id','=','mf_customer_master.id');
					$join->where('mf_customer_master.deleted_flag','N');
                     })
					 ->where('mf_product_order.deleted_flag','=',"N")->orderBy('mf_product_order.id','desc')->get();
        return $query;
    } 
	public static function getAlliteamsId($id){
		$query = ProductOrder::select('mf_product_order.*','mf_employee_master.name as employee_name','mf_customer_master.name as customer_name','mf_customer_master.address as customer_address','mf_customer_master.email_id as customer_email_id','mf_customer_master.contact as customer_contact')
					 ->leftjoin('mf_employee_master',function($join){
                    $join->on('mf_product_order.employee_id','=','mf_employee_master.id');
					$join->where('mf_employee_master.deleted_flag','N');
                     })
					 ->leftjoin('mf_customer_master',function($join){
                    $join->on('mf_product_order.customer_id','=','mf_customer_master.id');
					$join->where('mf_customer_master.deleted_flag','N');
                     })
					 ->where('mf_product_order.id','=',$id)->where('mf_product_order.deleted_flag','=',"N")->orderBy('mf_product_order.id','desc')->first();
        return $query;
    } 
	
	/*Get Report List*/

		
		public static function getAllreportlist($start_date,$end_date,$employee_name,$customer_name,$product){
		$TEMP = "mf_product_order.deleted_flag ='N' ";
		IF($start_date != ""){
			$TEMP .= " AND DATE(mf_product_order.created_date) >='$start_date' ";
		}
		IF($end_date != ""){
			$TEMP .= " AND DATE(mf_product_order.created_date) <='$end_date' ";
		}
		IF($employee_name != ""){
			$TEMP .= " AND mf_employee_master.name like '%$employee_name%' ";
			
		}
		IF($customer_name != ""){
			$TEMP .= " AND mf_customer_master.name like '%$customer_name%' ";
			
		}
		IF($product != ""){
			$TEMP .= " AND mf_order_items.product_id IN (".$product.") ";
			
		}
		
		
		$query = ProductOrder::selectRaw('mf_product_order.*,mf_employee_master.name as employee_name,mf_customer_master.name as customer_name')
				->leftjoin('mf_employee_master',function($join){
                    $join->on('mf_product_order.employee_id','=','mf_employee_master.id');
					$join->where('mf_employee_master.deleted_flag','N');
                     })
					 ->leftjoin('mf_customer_master',function($join){
                    $join->on('mf_product_order.customer_id','=','mf_customer_master.id');
					$join->where('mf_customer_master.deleted_flag','N');
                     })
					 ->leftjoin('mf_order_items',function($join){
                    $join->on('mf_product_order.id','=','mf_order_items.product_order_id');
					$join->where('mf_order_items.deleted_flag','N');
                     })
					
				->whereraw($TEMP)->orderBy('mf_product_order.id','desc')->groupBy('mf_product_order.id')->get();
		return $query;
		}
		public static function getAllOrderlistforCustomer($customer_id){
		$query = ProductOrder::select('mf_product_order.*','mf_employee_master.name as employee_name','mf_customer_master.name as customer_name')
					 ->leftjoin('mf_employee_master',function($join){
                    $join->on('mf_product_order.employee_id','=','mf_employee_master.id');
					$join->where('mf_employee_master.deleted_flag','N');
                     })
					 ->leftjoin('mf_customer_master',function($join){
                    $join->on('mf_product_order.customer_id','=','mf_customer_master.id');
					$join->where('mf_customer_master.deleted_flag','N');
                     })
					 ->where('mf_product_order.deleted_flag','=',"N")->where('mf_product_order.customer_id',$customer_id)->orderBy('mf_product_order.id','desc')->get();
        return $query;
    }
	
	
	
   
}
