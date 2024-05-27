<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OrderItems extends Authenticatable
{
	use Notifiable;
	
    public $timestamps = false;
    protected $table = 'mf_order_items';
    protected $fillable = ['id', 'product_id', 'quantity', 'product_order_id', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date','deleted_flag'];
	
	public static function getAlliteamsByemployeeId($id){
		$query = OrderItems::select('mf_order_items.*','mf_product_master.name as product_name','mf_product_master.image as product_image','mf_product_master.price as product_price')
               
					->leftjoin('mf_product_master',function($join){
                    $join->on('mf_order_items.product_id','=','mf_product_master.id');
					$join->where('mf_product_master.deleted_flag','N');
                     })
					
					 ->where('mf_order_items.product_order_id','=',$id)->where('mf_order_items.deleted_flag','N')->orderBy('mf_order_items.id','desc')->get();
        return $query;
    }
	public static function getAlliteamsByIdForView($id){
		$query = OrderItems::select('mf_order_items.*','mf_product_master.name as product_name','mf_product_master.image as product_image','mf_product_master.price as product_price')
               
					->leftjoin('mf_product_master',function($join){
                    $join->on('mf_order_items.product_id','=','mf_product_master.id');
					$join->where('mf_product_master.deleted_flag','N');
                     })
					
					 ->where('mf_order_items.product_order_id','=',$id)->where('mf_order_items.deleted_flag','N')->orderBy('mf_order_items.id','desc')->get();
        return $query;
    }
     	
    
}
