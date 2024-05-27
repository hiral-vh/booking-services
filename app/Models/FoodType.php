<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodType extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_food_category';

    public static function getFoodType()
    {
        $query=FoodType::orderBy('id','DESC')->paginate(10);
        return $query;
    }

    public static function getFoodTypeByName($name)
    {
        $query=FoodType::where('food_category_name','like','%'.$name.'%')->orderBy('id','DESC')->paginate(10);
        return $query;
    }

    public static function createFoodType($array)
    {
        $query=FoodType::create($array);
        return $query;
    }

    public static function updateFoodType($id,$array)
    {
        $query=FoodType::find($id)->update($array);
        return $query;
    }

    public static function deleteFoodType($id)
    {
        $query=FoodType::find($id)->delete();
        return $query;
    }
    public static function findFoodType($id)
    {
        $query=FoodType::find($id);
        return $query;
    }
}
