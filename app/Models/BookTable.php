<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookTable extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_book_table';

    public function tableDuration()
    {
        return $this->hasMany(BookTableDuration::class, 'id', 'book_table_id');
    }

    public function scopeRestaurantId($q){
        $restaurantId = auth()->guard('restaurantportal')->user()->restaurant_id;
        $q->where('restaurant_id', $restaurantId);
    }

}
