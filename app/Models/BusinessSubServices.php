<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessSubServices extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'business_sub_services';
    public $guarded = ["id"];

    public function productTeam()
    {
        return $this->hasMany(ProductWiseTeamMember::class, 'business_sub_services_id', 'id');
    }

    public function subService()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id', 'id');
    }

    public static function findSubServices($id)
    {
        $query = BusinessSubServices::with('productTeam')->find($id);
        return $query;
    }
    public static function getSubServices($business_id)
    {
        $query = BusinessSubServices::with('subService')->where('business_id',$business_id)->orderBy('id', 'DESC')->paginate(10);
        return $query;
    }

    public static function getSubServicesByFilter($businessId,$subServiceId='',$name='',$price,$time)
    {
        $query = BusinessSubServices::with('subService')->where('business_id',$businessId)->select('*');
        if($subServiceId != '')
        {
            $query->where('sub_service_id',$subServiceId);
        }
        if($name != '')
        {
            $query->where('name','like','%'.$name.'%');
        }
        if($price != '')
        {
            $query->where('price','like','%'.$price.'%');
        }
        if($time != '')
        {
            $query->where('time','like','%'.$time.'%');
        }

        return $query->orderBy('id', 'DESC')->paginate(10);
    }


    public static function listSubServices()
    {
        $query = BusinessSubServices::with('subService')->orderBy('name', 'ASC')->get();
        return $query;
    }

    public static function listSubServicesBusinessWise($businessId)
    {
        $query = BusinessSubServices::with('subService')->where('business_id',$businessId)->orderBy('name', 'ASC')->get();
        return $query;
    }

    public static function countSubServices($business_id)
    {
        $query = BusinessSubServices::where('business_id',$business_id)->count();
        return $query;
    }

    public static function updateSubServices($id, $array)
    {
        $query = BusinessSubServices::where('id', $id)->update($array);
        return $query;
    }

    public static function deleteSubServices($id)
    {
        $query = BusinessSubServices::find($id)->delete();
        return $query;
    }

    public static function getListBusinessWiseAndSubServiceId($subServiceId,$businessId)
    {
        $query = BusinessSubServices::where('sub_service_id',$subServiceId)->where('business_id',$businessId)->get();
        return $query;
    }
}
