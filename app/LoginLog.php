<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LoginLog extends Authenticatable {

    use Notifiable;

    public $timestamps = false;
    protected $table = 'mf_login_logs';
    protected $fillable = ['id', 'admin_fk', 'login_date', 'browser_details'];
    
}