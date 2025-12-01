<?php
namespace App\Filters\Coupons;

use Closure;

class TypeFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('type') && request()->type != "") {
            return $next($request)->where('type', request()->type);
        }

        return $next($request);

    }
}
