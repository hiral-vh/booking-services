<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminCategoryMaster extends Authenticatable {

    use Notifiable;

    public $timestamps = false;
    protected $table = 'mf_category_master';
    protected $fillable = ['id', 'name', 'slug', 'deleted_flag','created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date'];
    
    public static function editRecordById($id){
        $query = AdminCategoryMaster::where("deleted_flag",'N')->where('id',$id)->first();
        return $query;
    }
    
    public static function categoryList(){
        $query = AdminCategoryMaster::where("deleted_flag",'N')->orderBy('id','asc')->get();
        return $query;
    } 
	
	 public static function categoryListAscOrder(){
        $query = AdminCategoryMaster::where("deleted_flag",'N')->orderBy('name','asc')->get();
        return $query;
    }
    
	
    
}