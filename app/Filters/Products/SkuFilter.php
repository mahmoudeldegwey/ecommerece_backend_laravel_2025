<?php 
namespace App\Filters\Products;

use Closure;

class SkuFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('sku')) {
            return $next($request)->where('sku', 'LIKE', "%".request()->sku."%");
        }

        return $next($request);

    }
}

