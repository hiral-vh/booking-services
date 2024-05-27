<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessAboutUs extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'business_about_us';
    public $guarded=["id"];

    public function businessService()
    {
        return $this->belongsTo(BusinessService::class, 'business_service_id', 'id');
    }


    public static function getBusinessAboutUs($id)
    {
        $query=BusinessAboutUs::with('businessService')->where('business_id',$id)->first();
        return $query;
    }

    public static function getBusinessAboutUsForBusinessUser()
    {
        $query=BusinessAboutUs::with('business')->first();
        return $query;
    }

    public static function createBusinessAboutUs($array)
    {
        $query=BusinessAboutUs::create($array);
        return $query;
    }

    public static function findBusinessAboutUs($id)
    {
        $query=BusinessAboutUs::find($id);
        return $query;
    }

    public static function updateBusinessAboutUs($id,$array)
    {
        $query=BusinessAboutUs::find($id)->update($array);
        return $query;
    }

}
