<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BusinessUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessRecurringPaymentHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'business_recurring_payment_history';

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'plan_id', 'id');
    }


    public static function createBusinessRecurringPaymentHistory($array)
    {
        $array['created_at']=now();
        $query=BusinessRecurringPaymentHistory::create($array);
        return $query;
    }
    public static function getPlans($businessName,$userName,$planName)
    {
        $query = BusinessRecurringPaymentHistory::select('business_recurring_payment_history.business_id','business_recurring_payment_history.plan_id','business_recurring_payment_history.created_at')->with('subscription')->with('business',function($q){
            $q->with('businessUser');
        });
        if ($businessName != "") {
            $query->whereHas('business', function ($q) use ($businessName) {
                $q->where('name', 'like', '%' . $businessName . '%');
            });
        }
        if ($userName != "") {
            $query->whereHas('business', function ($q) use ($userName) {
                $q->whereHas('businessUser',function($d) use ($userName){
                    $d->where('name', 'like', '%' . $userName . '%');
            });
        });
        }
        if ($planName != "") {
            $query->whereHas('subscription', function ($q) use ($planName) {
                $q->where('plan_name', 'like', '%' . $planName . '%');
            });
        }
        $query->where('plan_id','!=',1);
        return $query->paginate(10);
    }
}
