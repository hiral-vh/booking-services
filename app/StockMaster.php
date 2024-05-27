<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StockMaster extends Authenticatable
{
	use Notifiable;
	
    public $timestamps = false;
    protected $table = 'mf_stock_master';
    protected $fillable = ['id', 'product_id', 'quantity_type','available_stock', 'quantity', 'deleted_flag', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date'];
	
	/*Customer List Function*/
	
	public static function stockList(){
		$query = StockMaster::select('mf_stock_master.*','mf_product_master.name as product_name')
		
					 ->leftjoin('mf_product_master',function($join){
                    $join->on('mf_stock_master.product_id','=','mf_product_master.id');
					$join->where('mf_product_master.deleted_flag','N');
                     })
					
					 ->where('mf_stock_master.deleted_flag','=',"N")->orderBy('mf_stock_master.id','desc')->get();
        return $query;
    } 
	public static function AvalilablestockList(){
		$query = StockMaster::select('mf_stock_master.*','mf_product_master.name as product_name','mf_category_master.name as category')
		
					 ->leftjoin('mf_product_master',function($join){
                    $join->on('mf_stock_master.product_id','=','mf_product_master.id');
					$join->where('mf_product_master.deleted_flag','N');
                     })
					  ->leftjoin('mf_category_master',function($join){
                    $join->on('mf_product_master.category_fk','=','mf_category_master.id');
					$join->where('mf_category_master.deleted_flag','N');
                     })
					
					 ->where('mf_stock_master.deleted_flag','=',"N")
					 ->whereRaw('mf_stock_master.id in(select max(id) from mf_stock_master group by product_id)')
					 ->groupBy('mf_stock_master.product_id')->orderBy('mf_stock_master.id','desc')->get();
        return $query;
    } 
	
   /*Edit Record Function*/
    public static function editRecordById($id){
        $query = StockMaster::where("deleted_flag",'N')->where('id',$id)->first();
        return $query;
    }
	
	public static function getRecordByproductId($id){
        $query = DB::table("mf_stock_master")->where('product_id',$id)->orderBy('mf_stock_master.id','desc')->first();
        return $query;
    }
	
   
}
