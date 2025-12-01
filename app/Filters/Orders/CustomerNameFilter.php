<?php 
namespace App\Filters\Orders;

use Closure;

class CustomerNameFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('customer_name')) {
            return $next($request)->where('customer_name', request()->customer_name);
        }

        return $next($request);

    }
}

