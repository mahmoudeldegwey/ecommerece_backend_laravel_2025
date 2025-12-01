<?php 
namespace App\Filters\Orders;

use Closure;

class OrderNumberFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('order_number')) {
            return $next($request)->where('order_number', request()->order_number);
        }

        return $next($request);

    }
}

