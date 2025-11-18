<?php
namespace App\Filters\Client;

use Closure;

class EmailFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('email') && request()->email != "") {
            return $next($request)->where('clients.email', request()->email);
        }

        return $next($request);

    }
}
