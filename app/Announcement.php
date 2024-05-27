<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Announcement extends Authenticatable
{
	use Notifiable;
	
    public $timestamps = false;
    protected $table = 'mf_announcement';
    protected $fillable = ['id', 'title', 'image', 'description', 'deleted_flag', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date'];
	
	 public static function getAllAnnouncement(){
        $query = Announcement::where("deleted_flag",'N')->orderBy('id','desc')->get();
        return $query;
    }
	
	/*Announcement List Function*/
	 public static function announcementList(){
        $query = Announcement::where("deleted_flag",'N')->orderBy('id','desc')->get();
        return $query;
    }
	
   /*Edit Record Function*/
    public static function editRecordById($id){
        $query = Announcement::where("deleted_flag",'N')->where('id',$id)->first();
        return $query;
    }
	
	
	
}
