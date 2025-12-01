<?php
namespace App\Filters;

use Closure;

class UserNameFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('username') && request()->username != "") {
            return $next($request)->where('users.name', request()->username);
        }

        return $next($request);

    }
}
