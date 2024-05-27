<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentPayment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'appointment_payment';
    public $guarded=["id"];

    public static function createAppointmentPayment($array)
    {
        $query=AppointmentPayment::create($array);
        return $query;
    }

    public static function deleteAppointmentPayment($id)
    {
        $query=AppointmentPayment::find($id)->delete();
        return $query;
    }

    public static function updateAppointmentPayment($id,$array)
    {
        $query=AppointmentPayment::find($id)->update($array);
        return $query;
    }

    public static function getTotalAmountSumByBusinessId($businessId)
    {
        $query=AppointmentPayment::where('business_id',$businessId)->sum('total_amount');
        return $query;
    }

    public static function getTotalPaymentByBusinessId($businessId)
    {
        $query=AppointmentPayment::where('business_id',$businessId)->count();
        return $query;
    }

    public static function getTotalPayments()
    {
        $query=AppointmentPayment::sum('total_amount');
        return $query;
    }

}
