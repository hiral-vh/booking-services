<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessNotification extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'business_notification';
    public $guarded=["id"];

    public static function getBusinessNotification()
    {
        $query=BusinessNotification::get();
        return $query;
    }

}
