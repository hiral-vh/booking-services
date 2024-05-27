<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserLoginLog extends Authenticatable {

    use Notifiable;

    public $timestamps = false;
    protected $table = 'mf_user_loginlog';
    protected $fillable = ['id', 'login_fk', 'login_date', 'browser_details'];
    
}