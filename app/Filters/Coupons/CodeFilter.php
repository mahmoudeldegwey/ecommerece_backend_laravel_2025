<?php
namespace App\Filters\Coupons;

use Closure;

class CodeFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('code') && request()->code != "") {
            return $next($request)->where('code', request()->code);
        }

        return $next($request);

    }
}
