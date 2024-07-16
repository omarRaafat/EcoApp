<?php
    namespace App\Pipelines\Admin\VendorUser;

    use Closure;

    class FilterName
    {
        public function handle($request, Closure $next)
        {
            $data = $next($request);

            if (request()->has('name') && request('name') != '')
            {
                return  $data->Where('name','like', '%' . request('name') . '%');
            }
            return $data;
        }
    }