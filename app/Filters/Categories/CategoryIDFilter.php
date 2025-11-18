<?php 
namespace App\Filters\Categories;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class CategoryIDFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('category_id')) {
            return $next($request)->where('id', request()->filled('category_id'));
        }

        return $next($request);

    }
}

