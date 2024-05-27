<?php

namespace App\Models;

use App\Models\Foodmenucategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foodmenusubcategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_food_menu_subcategory';

    public function cateogry()
    {
        return $this->belongsTo(Foodmenucategory::class, 'category_id', 'id');
    }
    public static function getCategory($category, $name)
    {
        $query = Foodmenusubcategory::select('fs_food_menu_subcategory.name', 'fs_food_menu_subcategory.image', 'fs_food_menu_subcategory.id', 'fs_food_menu_subcategory.category_id');
        $query->with('cateogry')->orderBy('id', 'DESC');
        if ($category != "") {
            $query->whereHas('cateogry', function ($q) use ($category) {
                $q->where('name', 'like', '%' . $category . '%');
            });
        }
        if ($name != "") {
            $query->where('fs_food_menu_subcategory.name', 'LIKE', '%' . $name . '%');
        }
        return $query->paginate(10);
    }
    public static function createSubCategory($array)
    {
        $query = Foodmenusubcategory::create($array);
        return $query;
    }

    public static function findSubCategory($id)
    {
        $query = Foodmenusubcategory::find($id);
        return $query;
    }

    public static function updateSubCategory($id, $array)
    {
        $query = Foodmenusubcategory::where('id', $id)->update($array);
        return $query;
    }
    public static function deleteSubCategory($id)
    {
        $query = Foodmenusubcategory::find($id)->delete();
        return $query;
    }
}
