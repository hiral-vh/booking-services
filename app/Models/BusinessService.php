<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessService extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'business_services';
    public $guarded = ["id"];

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    public function subservice()
    {
        return $this->hasMany(BusinessSubServices::class);
    }

    public static function getBusinessServicesAndSubService($id)
    {
        $query=BusinessService::with('subservice')->where('business_id',$id)->orderBy('id','desc')->get();
        return $query;
    }

    public static function getBusinessServices($id)
    {
        $query = BusinessService::with('business')->where('business_id', $id)->orderBy('id', 'desc')->paginate(10);
        return $query;
    }

    public static function getBusinessServicesForBusinessUser()
    {
        $query = BusinessAboutUs::with('business')->get();
        return $query;
    }

    public static function createBusinessServices($array)
    {
        $query = BusinessService::create($array);
        return $query;
    }

    public static function findBusinessServices($id)
    {
        $query = BusinessService::with('business')->find($id);
        return $query;
    }

    public static function updateBusinessService($id, $array)
    {
        $query = BusinessService::with('business')->where('id', $id)->update($array);
        return $query;
    }

    public static function deleteBusinessService($id)
    {
        $query = BusinessService::find($id)->delete();
        return $query;
    }
    public static function listServices()
    {
        $query = BusinessService::select('id', 'name')->get();
        return $query;
    }
}
