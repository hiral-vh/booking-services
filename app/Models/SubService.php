<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Services;

class SubService extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $timestamps = false;
    protected $table = 'sub_services';
    public $guarded = ["id"];

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id', 'id');
    }

    public function businesssubservice()
    {
        return $this->hasMany(BusinessSubServices::class, 'sub_service_id', 'id');
    }

    public function business()
    {
        return $this->hasOne(Business::class,'id','business_id');
    }

    public static function getSubServices($service, $name,$id,$business_id)
    {
        $query = SubService::select('sub_services.id', 'sub_services.name', 'sub_services.service_id', 'sub_services.status');
        $query->with('service');
        $query->orderBy('id', 'DESC');
        $query->where('service_id',$id);
        $query->where('created_by',$business_id);
        if ($service != "") {
            $query->whereHas('service', function ($q) use ($service) {
                $q->where('name', 'like', '%' . $service . '%');
            });
        }
        if ($name != "") {
            $query->where('sub_services.name', 'LIKE', '%' . $name . '%');
        }
        return $query->paginate(10);
    }

    public static function listSubServicesByServiceId($service_id)
    {
        $query = SubService::where('service_id', $service_id)->orderBy('name', 'ASC')->get();
        return $query;
    }

    public static function findSubServices($id)
    {
        $query = SubService::find($id);
        return $query;
    }
    public static function updateSubServices($id, $array)
    {
        $query = SubService::where('id', $id)->update($array);
        return $query;
    }

    public static function deleteSubServices($id)
    {
        $query = SubService::find($id)->delete();
        return $query;
    }
    public static function listSubServicesByServiceIdBusinessId($service_id,$business_id)
    {
        $query = SubService::where('service_id', $service_id)->where('created_by',$business_id)->orderBy('name', 'ASC')->get();
        return $query;
    }
}
