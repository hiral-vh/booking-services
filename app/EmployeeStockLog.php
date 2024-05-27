<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmployeeStockLog extends Authenticatable
{
	use Notifiable;
	
    public $timestamps = false;
    protected $table = 'mf_employee_stock_log';
    protected $fillable = ['id', 'product_id', 'type','employee_fk','distributor_fk', 'quantity','total_quantity', 'deleted_flag', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date'];
	
   public static function employeeStockList(){
		$query = EmployeeStockLog::select('mf_employee_stock_log.*','mf_product_master.name as product_name','mf_employee_master.name as employee_name','mf_distributor_master.name as distributor_name')
		
					 ->leftjoin('mf_product_master',function($join){
                    $join->on('mf_employee_stock_log.product_id','=','mf_product_master.id');
					$join->where('mf_product_master.deleted_flag','N');
                     })
                     ->leftjoin('mf_employee_master',function($join){
                     	$join->on('mf_employee_stock_log.employee_fk','=','mf_employee_master.id');
                     })
                      ->leftjoin('mf_distributor_master',function($join){
                     	$join->on('mf_employee_stock_log.distributor_fk','=','mf_distributor_master.id');
                     })
					
					 ->where('mf_employee_stock_log.deleted_flag','=',"N")->orderBy('mf_employee_stock_log.id','desc')->get();
        return $query;
    } 
    public static function checkQuantity($product_id,$employee_fk='',$distributor_fk=''){
    		$temp=' deleted_flag = "N" AND product_id="'.$product_id.'" ';
    	if($employee_fk!=''){
    		$temp.=' AND  employee_fk = "'.$employee_fk.'" ';
    	}else if($distributor_fk!=''){
    		$temp.=' AND  distributor_fk = "'.$distributor_fk.'" ';
    	}
    	$query=EmployeeStockLog::whereRaw($temp)->sum('quantity');
    	return $query;
    }
    public static function getRecordByEmployeeProductId($product_id,$type,$fkId){
    	$temp='product_id="'.$product_id.'"';
    	if($type==0){
    		$temp.=' AND  employee_fk="'.$fkId.'"';
    	}elseif($type==1){
    		$temp.='AND distributor_fk="'.$fkId.'"';
    	}
    	$query =EmployeeStockLog::whereRaw($temp)->orderBy('id','desc')->first();
        return $query;
    }
	/*Get last record by product id for service*/
	
	public static function getRecordByproductId($id){
        $query = DB::table("mf_employee_stock_log")->where('product_id',$id)->orderBy('mf_employee_stock_log.id','desc')->first();
        return $query;
    }
}
