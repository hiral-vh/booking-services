<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Login extends Authenticatable {

    use Notifiable;

    public $timestamps = false;
    protected $table = 'mf_admin_master';
    protected $fillable = [
        'id', 'first_name', 'last_name', 'email', 'address', 'mobile', 'photo', 'password', 'deleted_flag', 'active', 'rs', 'created_date', 'created_by', 'updated_date', 'updated_by', 'deleted_date', 'deleted_by'
    ];

   /*Check User Login Function*/
    public static function checkUserLogin($email, $password) {

        $query = Login::where('email', $email)->where('password','=',md5($password))->where('deleted_flag', 'N')->first();
        return $query;
    }

	/*Edit Login Function*/
    public static function editProfileById($id) {
        $query = Login::where('id', $id)->where('deleted_flag', 'N')->first();
        return $query;
    }

   /*Check Duplicate record Function*/
    public static function check_duplicate($email, $id) {
        $query = Login::where('id', '!=', $id)->where('email', $email)->where('deleted_flag', 'N')->count();
        return $query;
    }

   /*Get Admin By Email Function*/
    public static function get_admin_by_email($email) {
        $query = Login::where('email', $email)->where("active", "=", "active")->where('deleted_flag', 'N')->first();
        return $query;
    }

	/*Get Email Template Function*/
    public static function get_email_template($id) {
        $query = Login::where('id', $id)->where("active", "=", "active")->where('deleted_flag', 'N')->first();
        return $query;
    }
	/*Check Old password Function*/
    public static function CheckOldpassword($id,$password){
        $query = Login::where('deleted_flag','N')->where('password',$password)->where('id',$id)->first();

        return $query;
    }
	/*Check Code Function*/
    public static function checkCode($code){
        $query = Login::where('deleted_flag','N')->where('rs',$code)->count();
       return $query;
    }
	/*Get user by code Function*/
    public static function get_user_by_code($code){
        $query = Login::where('deleted_flag','N')->where('rs',$code)->first();
       return $query;
    }

}
