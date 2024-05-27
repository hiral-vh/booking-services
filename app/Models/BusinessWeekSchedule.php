<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BusinessWeekSchedule extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=false;
    protected $table = 'business_week_schedule';
    public $guarded=["id"];

   
}
