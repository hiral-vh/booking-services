<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessOffer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'business_offers';
    public $guarded=["id"];

    public function business()
    {
        return $this->hasOne(Business::class,'id','business_id');
    }

    public static function getBusinessOffer($id)
    {
        $query=BusinessOffer::with('business')->where('business_id',$id)->orderBy('id','desc')->paginate(10);
        return $query;
    }

    public static function getBusinessOfferBySearch($businessId,$name='',$price='',$discount='',$couponCode='')
    {
        $query=BusinessOffer::with('business')->where('business_id',$businessId);
        if($name != '')
        {
            $query->where('name','like','%'.$name.'%');
        }
        if($price != '')
        {
            $query->where('price','like','%'.$price.'%');
        }
        if($discount != '')
        {
            $query->where('discount','like','%'.$discount.'%');
        }
        if($couponCode != '')
        {
            $query->where('coupon_code','like','%'.$couponCode.'%');
        }
        return $query->orderBy('id','desc')->paginate(10);
    }

    public static function createBusinessOffer($array)
    {
        $query=BusinessOffer::create($array);
        return $query;
    }

    public static function couponCodeList($code,$id='')
    {
        $query=BusinessOffer::where('status',1);
        if($id != '')
        {
            $query->where('id','!=',$id);
        }
        $query->where('coupon_code',$code);        ;
        return $query->first();
    }

    public static function findOffer($id)
    {
        $query=BusinessOffer::find($id);
        return $query;
    }

    public static function updateOffer($id,$array)
    {
        $query=BusinessOffer::find($id)->update($array);
        return $query;
    }

    public static function deleteOffer($id)
    {
        $query=BusinessOffer::find($id)->delete();
        return $query;
    }

    public static function getOfferBusinessWise($businessId)
    {
        $query=BusinessOffer::where('business_id',$businessId)->get();
        return $query;
    }

    public static function checkOffer($businessId,$offerCode)
    {
        $query=BusinessOffer::where('business_id',$businessId)->where('coupon_code',$offerCode)->first();
        return $query;
    }
}

