<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminCustomerMaster extends Authenticatable
{
	use Notifiable;
	
    public $timestamps = false;
    protected $table = 'mf_customer_master';
    protected $fillable = ['id', 'name', 'address', 'posal_code', 'email_id', 'contact', 'type', 'notes', 'slug', 'deleted_flag', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date'];
	
	/*Customer List Function*/
	 public static function customerList(){
        $query = AdminCustomerMaster::where("deleted_flag",'N')->orderBy('id','desc')->get();
        return $query;
    }
	
   /*Edit Record Function*/
    public static function editRecordById($id){
        $query = AdminCustomerMaster::where("deleted_flag",'N')->where('id',$id)->first();
        return $query;
    }
	public static function checkExitEmail($email){
	
		$query = AdminCustomerMaster::where('email_id','=',$email)->where("deleted_flag",'N')->first();
		return $query;
	}
	public static function checkExitEmailForedit($email,$id){
	
		$query = AdminCustomerMaster::where('email_id','=',$email)->where("id",'!=',$id)->where("deleted_flag",'N')->first();
		return $query;
	}	
   
}
