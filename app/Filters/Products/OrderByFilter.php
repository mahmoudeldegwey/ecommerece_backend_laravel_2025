<?php 
namespace App\Filters\Products;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class OrderByFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('order_by')) {
            return $next($request)->orderBy('products.id', request()->order_by);
        }

        return $next($request);

    }
}

