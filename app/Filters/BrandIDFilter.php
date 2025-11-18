<?php 
namespace App\Filters;

use Closure;

class BrandIDFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('brand_id')) {
            return $next($request)->where('brand_id', request()->brand_id);
        }

        return $next($request);

    }
}

