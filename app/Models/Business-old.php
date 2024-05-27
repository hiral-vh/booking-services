<?php

namespace App\Models;

use App\Http\Resources\BusinessResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'business_owner';
    public $guarded = ["id"];

    public function business_user()
    {
        return $this->belongsTo(BusinessUser::class, 'business_user_id', 'id');
    }

    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }

    public function service()
    {
        return $this->hasOne(Services::class, 'id', 'service_id');
    }

    public function about()
    {
        return $this->hasOne(BusinessAboutUs::class, 'business_id', 'id');
    }

    public function appointment()
    {
        return $this->hasOne(BusinessAppointment::class, 'id', 'business_id');
    }

    public function businessTeamMember()
    {
        return $this->hasMany(BusinessTeamMember::class, 'business_id', 'id');
    }


    public static function getBusiness()
    {
        $query = Business::orderBy('id', 'desc')->paginate(10);
        return $query;
    }

    public static function getBusinessList($servicesId)
    {
        $query = Business::with('service')->where('status', 1)->where('numbers_of_appointment','!=',0)->orderBy('id', 'desc');
        if (!empty($servicesId)) {
            $query->whereIn('service_id', explode(',', $servicesId));
        }
        $query = $query->get();

        return $query;
    }

    public static function getBusinessById($id)
    {
        $businessData = Business::with('service', 'businessTeamMember')->where('id', $id)->first();
        return $businessData;
    }

    public static function createBusiness($array)
    {
        $query = Business::create($array);
        return $query;
    }

    public static function findBusiness($id)
    {
        $query = Business::find($id);
        return $query;
    }

    public static function findOnlyBusiness($id)
    {
        $query = Business::find($id);
        return $query;
    }

    public static function deleteBusiness($id)
    {
        $query = Business::find($id)->delete();
        return $query;
    }

    public static function updateBusiness($id, $array)
    {
        $query = Business::find($id)->update($array);
        return $query;
    }
    public static function getAllOwners($services, $name, $email, $mobile)
    {
        $query = Business::select('business_owner.name', 'business_owner.email', 'business_owner.contact', 'business_owner.country_code', 'business_owner.service_id');
        $query->with('service');
        $query->orderBy('id', 'desc');
        if ($services != "") {
            $query->whereHas('service', function ($q) use ($services) {
                $q->where('name', 'like', '%' . $services . '%');
            });
        }
        if ($name != "") {
            $query->where('business_owner.name', 'LIKE', '%' . $name . '%');
        }
        if ($email != "") {
            $query->where('business_owner.email', 'LIKE', '%' . $email . '%');
        }
        if ($mobile != "") {
            $query->where('business_owner.contact', 'LIKE', '%' . $mobile . '%');
        }
        return $query->paginate(10);
    }

}
