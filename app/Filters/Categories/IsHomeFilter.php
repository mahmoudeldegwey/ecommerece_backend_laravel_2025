<?php 
namespace App\Filters\Categories;

use Closure;

class IsHomeFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('is_home')) {
            return $next($request)->where('is_home', request()->is_home);
        }

        return $next($request);

    }
}

