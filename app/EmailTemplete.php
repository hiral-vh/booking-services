<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmailTemplete extends Authenticatable {

    use Notifiable;

    public $timestamps = false;
    protected $table = 'mf_email_templete';
    protected $fillable = ['id', 'title', 'subject', 'mail','deleted_flag', 'created_date', 'created_by', 'updated_date', 'updated_by', 'deleted_date', 'deleted_by'];

    public static function editRecordById($id){
        $query = EmailTemplete::where("deleted_flag",'N')->where('id',$id)->first();
        return $query;
    }

    public static function EmailTempleteList(){
        $query = EmailTemplete::where("deleted_flag",'N')->orderBy('id','desc');
        return $query;
    }
}
