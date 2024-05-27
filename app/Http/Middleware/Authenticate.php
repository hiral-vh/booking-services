<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $routeMiddleware = Route::current()->middleware();
        $route = explode(":", $routeMiddleware[1]);
        $routeName = $route[1];

        if (!$request->expectsJson()) {
            if ($routeName == 'business_user')
                return route('business-login');
            else
                return route('admin-login');
        }
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }
    }
}
