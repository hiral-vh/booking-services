<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminEmployeeMaster extends Authenticatable
{
	use Notifiable;

    public $timestamps = false;
    protected $table = 'mf_employee_master';
    protected $fillable = ['id', 'name', 'city', 'date_of_birth', 'address', 'posal_code', 'image', 'email_id', 'password', 'employee_code', 'otp',  'contact', 'type', 'notes', 'slug', 'deleted_flag', 'created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date','active_status'];

	/*Customer List Function*/
	 public static function employeeList(){
        $query = AdminEmployeeMaster::where("deleted_flag",'N')->orderBy('id','desc')->get();
        return $query;
    }

   /*Edit Record Function*/
    public static function editRecordById($id){
        $query = AdminEmployeeMaster::where("deleted_flag",'N')->where('id',$id)->first();
        return $query;
    }

	  public static function lastEmployeeCode(){
        $query = DB::table("mf_employee_master")->select("id")->orderBy('mf_employee_master.id','desc')->first();
        return $query;
    }
	 public static function checkEmployeeCode($code){
        $query = AdminEmployeeMaster::where("employee_code",$code)->first();
        return $query;
    }


	/*Web service related function */

	public static function CheckAccountByEmailAddress($email){

        $query = AdminEmployeeMaster::where('email_id','LIKE',"%".$email."%")->where("active_status",1)->where("deleted_flag",'N')->count();
        return $query;
	}

	public static function checkOtpById($otp,$id){
		$query = AdminEmployeeMaster::where('otp',$otp)->where('id',$id)->where("deleted_flag",'N')->first();
		return $query;
	}

	public static function checkById($id){
		$query = AdminEmployeeMaster::where('id',$id)->where("deleted_flag",'N')->first();
		return $query;
	}

	public static function GetResponseByEmail($email,$pass){
		$query = AdminEmployeeMaster::where('email_id', '=',$email)->where('password','=',md5($pass))->where("deleted_flag",'N')->first();
        return $query;
	}

	public static function GetResponseByEmailForforgotpass($email){

		$query = AdminEmployeeMaster::where('email_id','=',$email)->where("deleted_flag",'N')->first();
		return $query;
	}

	public static function checkPassword($id,$pass){
        $query = AdminEmployeeMaster::where("password",md5($pass))->where("active_status",1)->where('id',$id)->first();
        return $query;
    }
	public static function checkExitEmail($email){

		$query = AdminEmployeeMaster::where('email_id','=',$email)->where("deleted_flag",'N')->first();
		return $query;
	}

	/*End web service related function */

}
