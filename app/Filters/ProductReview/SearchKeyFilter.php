<?php 
namespace App\Filters\Products;

use Closure;

class SearchKeyFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('search_key')) {
            return $next($request)
            ->where('username', 'LIKE', '%' . request()->search_key . '%')
            ->orWhereHas('product', function ($q) {
                $q->where('name', 'LIKE', '%' . request()->search_key . '%');
            });
        }

        return $next($request);

    }
}

