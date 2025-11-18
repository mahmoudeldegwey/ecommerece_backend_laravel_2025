<?php 
namespace App\Filters\Products;

use Closure;

class ProductIDFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('product_id')) {
            return $next($request)->where('product_id', request()->product_id);
        }

        return $next($request);

    }
}

