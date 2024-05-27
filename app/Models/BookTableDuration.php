<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTableDuration extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_book_table_duration';

    public function scopeRestaurantId($q)
    {
        $restaurantId = auth()->guard('restaurantportal')->user()->restaurant_id;
        $q->where('restaurant_id', $restaurantId);
    }
}
