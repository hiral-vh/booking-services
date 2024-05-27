<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessTeamMemberTimeSlot extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'business_team_members_time_slot';
    public $guarded = ["id"];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    public function teamMember()
    {
        return $this->belongsTo(BusinessTeamMember::class, 'business_team_member_id', 'id');
    }

    public static function getdataByBussinessIdAndTeamMemberId($business_id, $team_member_id)
    {
        $query = BusinessTeamMemberTimeSlot::where('business_id', $business_id)->where('business_team_member_id', $team_member_id)->get();
        return $query;
    }

    public static function listdataByBussinessIdAndTeamMemberId($business_id, $team_member_id)
    {
        $query = BusinessTeamMemberTimeSlot::with('teamMember')->where('business_id', $business_id)->where('business_team_member_id', $team_member_id)->paginate(10);
        return $query;
    }

    public static function createSchedule($array)
    {
        $query=BusinessTeamMemberTimeSlot::create($array);
        return $query;
    }
    public static function countBusinessTeamMemberWeekScheduleById($business_team_member_id)
    {
        $query = BusinessTeamMemberTimeSlot::where('business_team_member_id', $business_team_member_id)->count();
        return $query;
    }

    
    // public static function findBusinessTeamMemberWeekScheduleByTeamMemberIdAndDay($business_team_member_id,$day)
    // {
    //     $query=BusinessTeamMemberTimeSlot::where('business_team_member_id',$business_team_member_id)->where('day',$day)->first();
    //     return $query;
    // }

    public static function getTeammemberTimeSlotList($teamMemberId,$day,$time='')
    {
      //  echo $currentTime; die();
        $query = BusinessTeamMemberTimeSlot::select('business_team_members_time_slot.*','business_appointment.*')
        ->leftjoin('business_appointment', function ($join) {
            $join->on('business_team_members_time_slot.business_team_member_id', '=','business_appointment.business_team_members_id');
        })
        ->where('business_team_members_time_slot.business_team_member_id', $teamMemberId)
        ->where('business_team_members_time_slot.day',$day)
        ->groupBy('business_team_members_time_slot.start_time');
     
        if($time)
        {
            $query->where('business_team_members_time_slot.start_time','!=',$time);
        }
       
        return $query->get();
    }

    public static function getTeamMemberTimeSlots($id)
    {
        $query = BusinessTeamMemberTimeSlot::where('business_team_member_id',$id)->get();
        return $query;
    }
  
}
