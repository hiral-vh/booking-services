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

    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }

    public function service()
    {
        return $this->hasOne(Services::class, 'id', 'service_id');
    }

    public function businessRecurringPaymentHistory()
    {
        return $this->hasMany(BusinessRecurringPaymentHistory::class, 'business_id', 'id');
    }

    public function businessUser()
    {
        return $this->hasOne(BusinessUser::class, 'business_id', 'id');
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

    public static function getTotalSubscribedBusiness()
    {
        $query = Business::where('subscription_flag', 2);
        return $query;
    }

    public static function getBusiness()
    {
        $query = Business::orderBy('id', 'desc')->paginate(10);
        return $query;
    }

    public function businessWeekSchedule()
    {
       return $this->hasMany(BusinessWeekSchedule::class,'business_id','id');
    }

    public static function getBusinessList($servicesId)
    {
        $query = Business::with(['service', 'businessUser','businessWeekSchedule'])->where('status', 1)->where('numbers_of_appointment', '!=', 0)
            ->whereHas('businessUser', function ($q) {
                $q->where('is_verify', 1);
            });
        if (!empty($servicesId)) {
            $query->whereIn('service_id', explode(',', $servicesId));
        }
        return $query->orderBy('id', 'desc')->get();
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
        $query = Business::select('business_owner.id', 'business_owner.name', 'business_owner.email', 'business_owner.contact', 'business_owner.country_code', 'business_owner.service_id')->with('businessRecurringPaymentHistory', function ($qs) {
            $qs->with('subscription')->orderBy('id', 'DESC');
        })->with('service')->orderBy('id', 'desc');
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
    public static function getPlanDetails()
    {
        $query = Business::select('business_owner.*', 'business_recurring_payment_history.end_date')
            ->join('business_recurring_payment_history', 'business_recurring_payment_history.business_id', '=', 'business_owner.id')
            ->whereNull('business_owner.deleted_at')
            ->orderBy('business_recurring_payment_history.created_at', 'desc')
            ->groupBy('business_recurring_payment_history.business_id');

        return $query;
    }
    public static function getBusinessLessOrders()
    {
        $query = Business::where('numbers_of_appointment', 10)->whereNull('deleted_at')->get();
        return $query;
    }
    public static function getDetailsById($id)
    {
        $query = Business::where('id', $id)->first();
        return $query;
    }
}
