<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Userbooktable extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_user_book_table';

    public static  function insert($data)
    {
        $Auth = auth()->user();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($Auth) {
            $data['created_by'] = $Auth['id'];
        }

        $insert = new Userbooktable($data);
        $insert->save();
        $insertId = $insert->id;
        return $insertId;
    }
    public function booktime()
    {
        return $this->hasOne(BookTableDuration::class, 'id', 'book_table_id');
    }
    public function booktabletime()
    {
        return $this->hasOne(BookTableDuration::class, 'id', 'book_table_time_id');
    }
    public function booktablename()
    {
        return $this->hasOne(BookTable::class, 'id', 'book_table_id');
    }
    public function tableTime()
    {
        return $this->hasOne(BookTableDuration::class,'id','book_table_time_id');
    }
    public function tableName()
    {
        return $this->hasOne(BookTable::class,'id','book_table_id');
    }
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
