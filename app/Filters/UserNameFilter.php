<?php
namespace App\Filters;

use Closure;

class UserNameFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('name') && request()->name != "") {
            return $next($request)->where('users.name', request()->name);
        }

        return $next($request);

    }
}
