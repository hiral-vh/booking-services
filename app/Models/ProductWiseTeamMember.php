<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BusinessTeamMember;

class ProductWiseTeamMember extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'business_productwise_team_members';
    public $guarded = ["id"];


    public function teamMember()
    {
        return $this->belongsTo(BusinessTeamMember::class, 'team_member_id', 'id');
    }

    public static function getTeammemberListBusinessSubServiceWise($businessSubServicesId)
    {
        $query=ProductWiseTeamMember::with('teamMember')->where('business_sub_services_id',$businessSubServicesId)->get();
        return $query;
    }

    public static function getTeamMemberListAPI($id)
    {
        $query = ProductWiseTeamMember::select('business_team_members.created_at as team_member_Date','business_team_members.name','business_productwise_team_members.business_sub_services_id','business_productwise_team_members.team_member_id','business_productwise_team_members.price','business_productwise_team_members.id')
        ->leftjoin('business_team_members', function ($join) {
            $join->on('business_productwise_team_members.team_member_id', '=','business_team_members.id');
        })
        ->orderBy('team_member_Date','DESC')
        ->where('business_productwise_team_members.business_sub_services_id',$id)
        ->get();
        return $query;
    }
}
