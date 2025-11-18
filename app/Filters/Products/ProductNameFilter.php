<?php 
namespace App\Filters\Products;

use Closure;

class ProductNameFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('name')) {
            return $next($request)->where('name', 'LIKE', "%".request()->name."%");
        }

        return $next($request);

    }
}

