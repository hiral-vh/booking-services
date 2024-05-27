<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foodmenucategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_food_menu_category';

    public function subCategory()
    {
        return $this->hasMany(Foodmenusubcategory::class, 'category_id', 'id');
    }
    public static function createCategory($array)
    {
        $query = Foodmenucategory::create($array);
        return $query;
    }

    public static function findCategory($id)
    {
        $query = Foodmenucategory::find($id);
        return $query;
    }

    public static function updateCategory($id, $array)
    {
        $query = Foodmenucategory::where('id', $id)->update($array);
        return $query;
    }
    public static function getCategory($name)
    {
        $query = Foodmenucategory::select('fs_food_menu_category.name', 'fs_food_menu_category.id');
        $query->orderBy('id', 'DESC');
        if ($name != "") {
            $query->where('fs_food_menu_category.name', 'LIKE', '%' . $name . '%');
        }
        return $query->paginate(10);
    }
    public static function listCategory()
    {
        $query=Foodmenucategory::get();
        return $query;
    }
    public static function deleteCategory($id)
    {
        $query = Foodmenucategory::find($id)->delete();
        return $query;
    }
}
