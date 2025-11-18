<?php
namespace App\Filters\Client;

use Closure;

class UsernameFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('username') && request()->username != "") {
            return $next($request)->where('clients.username', request()->username);
        }

        return $next($request);

    }
}
