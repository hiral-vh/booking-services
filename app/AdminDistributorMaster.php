<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminDistributorMaster extends Authenticatable
{
	use Notifiable;
	
    public $timestamps = false;
    protected $table = 'mf_distributor_master';
    protected $fillable = ['id', 'name', 'address', 'posal_code', 'email_id', 'contact', 'slug', 'deleted_flag', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date'];
	
	/*Distributor List Function*/
	 public static function distributorList(){
        $query = AdminDistributorMaster::where("deleted_flag",'N')->orderBy('id','desc')->get();
        return $query;
    }

    /*Edit Record Function*/
    public static function editRecordById($id){
        $query = AdminDistributorMaster::where("deleted_flag",'N')->where('id',$id)->first();
        return $query;
    }	
   
}
