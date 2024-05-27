<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminProductMaster extends Authenticatable
{
	use Notifiable;
	
    public $timestamps = false;
    protected $table = 'mf_product_master';
    protected $fillable = ['id', 'name', 'category_fk', 'box_quantity', 'inner_quantity' , 'price', 'image', 'slug', 'deleted_flag', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date'];
	
	/*Product List Function*/
	public static function productList(){
		$query = AdminProductMaster::select('mf_product_master.*','mf_category_master.name as category')
                ->join('mf_category_master',function($join){
                    $join->on('mf_product_master.category_fk','=','mf_category_master.id');
                    $join->where('mf_category_master.deleted_flag','N');
                     })
					 ->where('mf_product_master.deleted_flag','=',"N")->orderBy('mf_product_master.id','desc')->get();
        return $query;
    }

    /*Edit Record Function*/
    public static function editRecordById($id){
        $query = AdminProductMaster::where("deleted_flag",'N')->where('id',$id)->first();
        return $query;
    }	
	
	
   
}
