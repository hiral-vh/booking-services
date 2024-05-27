<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Sitesetting extends Authenticatable {

    use Notifiable;

    public $timestamps = false;
    protected $table = 'mf_site_setting';
    protected $fillable = ['id', 'payment_getway', 'sms_mobile', 'sms_api', 'sms_screte', 'deleted_flag', 'created_date', 'created_by', 'updated_date', 'updated_by', 'deleted_date', 'deleted_by'];
    
    public static function sitesettingList(){
        $query = Sitesetting::where("deleted_flag",'N')->where('id',1)->first();
        return $query;
    }
}