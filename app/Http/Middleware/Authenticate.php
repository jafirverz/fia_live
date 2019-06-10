<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        $redirectTo = 'login';
        if (! $request->expectsJson()) {
            if (strpos($request->url(), 'admin') !== false) {
                $redirectTo = 'admin_login';
            }
            return route($redirectTo);
        }
    }
}
