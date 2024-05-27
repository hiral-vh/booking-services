<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeSlots extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'business_team_members_timeslots';
    public $guarded = ["id"];

    public static function getTimeslotsByTeamId($id, $tid)
    {
        $query = TimeSlots::select('timeslots')->where('team_member_id', $tid)->where('business_id', $id)->get();
        return $query;
    }
}
