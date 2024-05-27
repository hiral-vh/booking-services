<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcription extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'subscription_master';

    public static  function insert($data)
    {
        $Auth = auth()->user();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($Auth) {
            $data['created_by'] = $Auth['id'];
        }

        $insert = new Subcription($data);
        $insert->save();
        $insertId = $insert->id;
        return $insertId;
    }
    public function paymentHistory()
    {
        return $this->belongsTo(BusinessRecurringPaymentHistory::class, 'id', 'plan_id');
    }
    public static function getAllsubscription(){

        return Subcription::whereNull('deleted_at')->where('type','business')->orderBy('id','asc')->get();
    }
  
    public static function getSubscription($id)
    {
        $query = Subcription::select('subscription_master.*', 'business_recurring_payment_history.*','business_recurring_payment_history.start_date', 'business_recurring_payment_history.end_date','business_owner.numbers_of_appointment','business_owner.id')
        ->join('business_recurring_payment_history', 'subscription_master.id', '=', 'business_recurring_payment_history.plan_id')
        ->leftjoin('business_owner', function ($join) {
            $join->on('business_recurring_payment_history.business_id', '=','business_owner.id');
        })
            ->where('business_recurring_payment_history.business_id', $id)
            ->whereNull('business_recurring_payment_history.deleted_at')
            ->whereNull('subscription_master.deleted_at')
            ->orderBy('business_recurring_payment_history.id','DESC')
            ->first();

        return $query;
    }
 
}
