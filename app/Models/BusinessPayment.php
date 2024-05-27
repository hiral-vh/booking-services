<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessPayment extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'business_payment';

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    public static function getBusinessPaymentByBusinessId($businessId)
    {
        $query=BusinessPayment::where('business_id',$businessId)->first();
        return $query;
    }

    public static function createBusinessPayment($array)
    {
        $query=BusinessPayment::create($array);
        return $query;
    }
}
