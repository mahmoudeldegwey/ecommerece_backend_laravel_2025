<?php
namespace App\Filters\Users;

use Closure;

class UserEmailFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('email') && request()->email != "") {
            return $next($request)->where('users.email', request()->email);
        }

        return $next($request);

    }
}
