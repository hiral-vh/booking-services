<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class NoteMaster extends Authenticatable
{
	use Notifiable;
	
    public $timestamps = false;
    protected $table = 'mf_note';
    protected $fillable = ['id','product_order_fk', 'employee_id', 'customer_id', 'note', 'deleted_flag', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date'];
	
	
    public static function getAllrecord(){
		$query = NoteMaster::select('mf_note.*','mf_employee_master.name as employee_name','mf_customer_master.name as customer_name')
               
					->leftjoin('mf_employee_master',function($join){
                    $join->on('mf_note.employee_id','=','mf_employee_master.id');
					$join->where('mf_employee_master.deleted_flag','N');
                     })
					 ->leftjoin('mf_customer_master',function($join){
                    $join->on('mf_note.customer_id','=','mf_customer_master.id');
					$join->where('mf_customer_master.deleted_flag','N');
                     })
					
					 ->where('mf_note.deleted_flag','N')->orderBy('mf_note.id','desc')->get();
        return $query;
    }	
	 public static function GetnoteByemployeeId($employee_id){
        $query = NoteMaster::where("deleted_flag",'N')->where('product_order_fk',$employee_id)->get();
        return $query;
    }	
	
   
}
