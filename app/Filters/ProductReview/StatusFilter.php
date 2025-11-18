<?php 
namespace App\Filters\ProductReview;

use Closure;

class StatusFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('status')) {
            return $next($request)->where('status', request()->status);
        }

        return $next($request);

    }
}

