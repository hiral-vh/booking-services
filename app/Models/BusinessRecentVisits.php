<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessRecentVisits extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'business_recent_visits';
    public $guarded=["id"];


    public function business()
    {
        return $this->hasOne(Business::class,'id',"business_id");
    }

    public function businessWeekSchedule()
    {
        return $this->hasMany(BusinessWeekSchedule::class,'business_id','business_id');
    }
    
    public static function getRecentVisitsBusiness($id)
    {
        $query=BusinessRecentVisits::select('business_recent_visits.business_id','business_owner.*','services.name as servicename')->with('businessWeekSchedule')
        ->join('business_owner', function ($join) {
            $join->on('business_owner.id', '=', 'business_recent_visits.business_id');
        })
        ->join('services', function ($join) {
            $join->on('services.id', '=', 'business_owner.service_id');
        })
        
        ->where('business_recent_visits.user_id',$id)
        ->orderBy('business_recent_visits.id','DESC')
        ->groupBy('business_recent_visits.business_id')
        ->get();
        
        return $query;
    }

    public static function createBusinessRecentVisits($array)
    {
        $query=BusinessRecentVisits::create($array);
        return $query;
    }

}
