<?php

namespace App\Http\Middleware;

use App\Models\Business;
use App\Models\BusinessRecurringPaymentHistory;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user=Auth::guard('business_user')->user();
        $businessData = Business::find($user->business_id);
        $businessRecurringPaymentData = BusinessRecurringPaymentHistory::where('business_id',$user->business_id)->orderBy('id','DESC')->first();
        $currentDate=strtotime(date('Y-m-d h:i:s', strtotime(now())));
        $endDate=strtotime(date('Y-m-d h:i:s', strtotime($businessRecurringPaymentData->end_date)));

        if($currentDate >= $endDate && $businessData->subscription_flag == 2)
        {
            Business::updateBusiness($user->business_id,['subscription_flag' => 0,'numbers_of_appointment' => 0]);
            return redirect('subscription');
        }

        if ($businessData) {
            if ($businessData->subscription_flag == 0) {
               return redirect('subscription');
            }
            return $next($request);
        }

    }
}
