<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ownerrecuringhistory extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_owner_recurring_payment_history';

    public static function getTrialSubscription($id)
    {
        $query = Ownerrecuringhistory::select('fs_owner.total_orders', 'fs_owner_recurring_payment_history.start_date', 'fs_owner_recurring_payment_history.end_date')
            ->join('fs_owner', 'fs_owner.id', '=', 'fs_owner_recurring_payment_history.user_id')
            ->where('fs_owner_recurring_payment_history.user_id', $id)
            ->whereNull('fs_owner_recurring_payment_history.deleted_at')
            ->orderBy('fs_owner_recurring_payment_history.id', 'DESC');

        return $query;
    }
}
