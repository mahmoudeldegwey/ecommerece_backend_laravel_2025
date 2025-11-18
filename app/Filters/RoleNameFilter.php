<?php
namespace App\Filters;

use Closure;

class RoleNameFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('name') && request()->name != "") {
            return $next($request)->where('roles.name', request()->name);
        }

        return $next($request);

    }
}
