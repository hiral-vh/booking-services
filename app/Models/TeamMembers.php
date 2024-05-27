<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMembers extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'team_members';
    public $guarded=["id"];


    public function teamMember()
    {
        return $this->hasOne(BusinessTeamMember::class,'team_member_id','id');
    }

    public static function getTeamMembers()
    {
        $query=TeamMembers::orderBy('id')->paginate(10);
        return $query;
    }

    public static function getTeamMembersList()
    {
        $query=TeamMembers::orderBy('name','asc')->get();
        return $query;
    }

    public static function createTeamMember($array)
    {
        $query=TeamMembers::create($array);
        return $query;
    }

    public static function findTeamMember($id)
    {
        $query=TeamMembers::find($id);
        return $query;
    }

    public static function findTeamMemberWithReturnResponse($id)
    {
        $query=TeamMembers::select('id','name','charge')->where('status',1)->find($id);
        return $query;
    }

    public static function updateTeamMember($id,$array)
    {
        $query=TeamMembers::find($id)->update($array);
        return $query;
    }

    public static function deleteTeamMember($id)
    {
        $query=TeamMembers::find($id)->delete();
        return $query;
    }

}

