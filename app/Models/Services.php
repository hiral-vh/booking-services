<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Services extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $timestamps = false;
    protected $table = 'services';
    public $guarded = ["id"];

    public static function getServices($name)
    {
        $query = Services::select('services.id', 'services.name', 'services.image', 'services.status');
        $query->orderBy('id', 'DESC');
        if ($name != "") {
            $query->where('services.name', 'LIKE', '%' . $name . '%');
        }
        return $query->paginate(10);
    }

    public static function listServices()
    {
        $query = Services::select('id', 'name', 'image', 'status')->orderBy('name', 'asc')->get();
        return $query;
    }

    public static function createServices($array)
    {
        $query = Services::create($array);
        return $query;
    }

    public static function findServices($id)
    {
        $query = Services::find($id);
        return $query;
    }

    public static function updateServices($id, $array)
    {
        $query = Services::where('id', $id)->update($array);
        return $query;
    }

    public static function deleteService($id)
    {
        Services::find($id)->update(['deleted_by'=>Auth::guard('admin')->user()->id]);
        $query = Services::find($id)->delete();
        return $query;
    }
}
