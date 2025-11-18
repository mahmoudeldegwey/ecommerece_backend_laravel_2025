<?php
namespace App\Filters;

use Closure;

class SuperUserFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('super_user') && request()->super_user == 1) {
            return $next($request)->where('users.super_user', request()->super_user);
        }

        return $next($request);

    }
}
