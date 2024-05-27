<?php

namespace App\Models;

use App\Models\FoodUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Userdeliveryaddress extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_user_delivery_address';

    public function user()
    {
        return $this->belongsTo(FoodUser::class,'id','user_id');
    }

    public static  function insert($data)
    {
        $Auth = auth()->user();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($Auth) {
            $data['created_by'] = $Auth['id'];
        }

        $insert = new Userdeliveryaddress($data);
        $insert->save();
        $insertId = $insert->id;
        return $insertId;
    }
}
