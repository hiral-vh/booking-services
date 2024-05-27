<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessTeamMember extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'business_team_members';
    public $guarded=["id"];

    public function business()
    {
        return $this->hasOne(Business::class,'id','business_id');
    }

    public static function getBusinessTeamMembers($business_id)
    {
        $query=BusinessTeamMember::with('business')->where('business_id',$business_id)->orderBy('id','desc')->paginate(10);
        return $query;
    }

    public static function getBusinessTeamMembersByFilter($business_id,$teamMember='',$email='',$phone='')
    {
        $query=BusinessTeamMember::with('business')->where('business_id',$business_id)->select('*');
        if($teamMember != '')
        {
            $query->where('id',$teamMember);
        }
        if($email != '')
        {
            $query->where('email','LIKE','%'.$email.'%');
        }
        if($phone != '')
        {
            $query->where('phone_no','LIKE','%'.$phone.'%');
        }
        return $query->orderBy('id','desc')->paginate(10);
    }

    public static function listBusinessTeamMembers($business_id)
    {
        $query=BusinessTeamMember::with('business')->where('business_id',$business_id)->orderBy('name','ASC')->get();
        return $query;
    }

    public static function createBusinessTeamMembers($array)
    {
        $query=BusinessTeamMember::create($array);
        return $query;
    }

    public static function findBusinessTeamMember($id)
    {
        $query=BusinessTeamMember::find($id);
        return $query;
    }

    public static function updateBusinessTeamMember($id,$array)
    {
        $query=BusinessTeamMember::where('id',$id)->update($array);
        return $query;
    }

    public static function deleteBusinessTeamMember($id)
    {
        $query=BusinessTeamMember::find($id)->delete();
        return $query;
    }

    public static function checkTeamMemberRecordExist($name,$business_id,$email)
    {
        return BusinessTeamMember::where('business_id',$business_id)->where('name',$name)->where('email',$email)->first();
    }

    public static function findBusinessTeamMemberByBusinessId($business_id)
    {
        return BusinessTeamMember::where('business_id',$business_id)->where('status',1)->get();
    }
    public static function checkTeamMemberRecordExistEdit($name,$business_id,$id,$email)
    {
        return BusinessTeamMember::where('id','!=',$id)->where('business_id',$business_id)->where('name',$name)->where('email',$email)->first();
    }
    public static function checkEmail($email)
    {
        $query = BusinessTeamMember::where("email", $email)->first();
        return $query;
    }
    public static function checkMobile($mobile)
    {
        $query = BusinessTeamMember::where("phone_no", $mobile)->first();
        return $query;
    }

}
