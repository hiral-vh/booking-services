<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;
    public $timestamps=false;

    public $table="site_settings";

    public $guarded=["id"];

    public static function getSiteSettings()
    {
        $query=SiteSetting::first();
        return $query;
    }

    public static function updateSiteSettings($array)
    {
        $query=SiteSetting::first()->update($array);
        return $query;
    }

}
