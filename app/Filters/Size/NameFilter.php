<?php
namespace App\Filters\Size;

use Closure;

class NameFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('name') && request()->name != "") {
            return $next($request)->where('name', request()->name);
        }

        return $next($request);

    }
}
