<?php

namespace App\Pipelines\Admin\Vendor;

use Closure;

class FilterRating
{
    public function handle($request, Closure $next)
    {
        $data = $next($request);
        $rating = request('rating');
        if (request()->has('rating') && $rating != '') {
            return $data->Where('rate', ">=", $rating);
        }
        return $data;
    }
}
