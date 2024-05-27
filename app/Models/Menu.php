<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_menu';

    public function category()
    {
        return $this->hasOne(Foodmenucategory::class, 'id', 'category_id');
    }

    public function subCategory()
    {
        return $this->hasOne(Foodmenusubcategory::class, 'id', 'sub_category_id');
    }
    public function scopeRestaurantId($q)
    {
        $restaurantId = auth()->guard('restaurantportal')->user()->restaurant_id;
        $q->where('restaurant_id', $restaurantId);
    }
}
