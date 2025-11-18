<?php 
namespace App\Filters\Categories;

use Closure;

class IsMenuFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('is_menu')) {
            return $next($request)->where('is_menu', request()->is_menu);
        }

        return $next($request);

    }
}

