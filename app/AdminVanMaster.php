<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminVanMaster extends Authenticatable
{
	use Notifiable;
	
    public $timestamps = false;
    protected $table = 'mf_van_master';
    protected $fillable = ['id', 'distributor_fk', 'driver', 'van_no', 'slug', 'deleted_flag', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date'];
	
	
	/*Van List Function*/
	 public static function vanList(){
        $query = AdminVanMaster::where("deleted_flag",'N')->orderBy('id','desc')->get();
        return $query;
    }

   /*Edit Record Function*/
    public static function editRecordById($id){
        $query = AdminVanMaster::where("deleted_flag",'N')->where('id',$id)->first();
        return $query;
    }	
   
}
