<?php 
namespace App\Filters\Orders;

use Closure;

class CustomerPhoneFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('customer_phone')) {
            return $next($request)->where('customer_phone', request()->customer_phone);
        }

        return $next($request);

    }
}

