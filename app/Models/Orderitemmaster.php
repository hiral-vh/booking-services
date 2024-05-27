<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orderitemmaster extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_order_item_master';

    public static  function insert($data)
    {
        $Auth = auth()->user();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($Auth) {
            $data['created_by'] = $Auth['id'];
        }

        $insert = new Orderitemmaster($data);
        $insert->save();
        $insertId = $insert->id;
        return $insertId;
    }
    public function menudata()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id');
    }

    public function order()
    {
        return $this->belongsTo(Ordermaster::class, 'order_id', 'id');
    }
}
