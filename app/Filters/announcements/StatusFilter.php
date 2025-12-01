<?php
namespace App\Filters\Announcements;

use Closure;

class StatusFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('status') && request()->name != "") {
            return $next($request)->where('is_active', request()->status);
        }

        return $next($request);

    }
}
