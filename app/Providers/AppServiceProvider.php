<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Models\Notification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {

            $getSiteSetting = array();
            $getSiteSetting = SiteSetting::getSiteSettings(); //...with this variable
            $getNotification = Notification::adminNotification();
            $view->with('sitesetting', $getSiteSetting);
            $view->with('notification',$getNotification);
        });
    }
}
