<?php 
namespace App\Filters\Products;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class CategoryIDFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('category_id')) {
            return $next($request)->whereHas('categories', function(Builder $query){
                $query->where('product_categories.category_id',  request()->category_id);
            });
        }

        return $next($request);

    }
}

