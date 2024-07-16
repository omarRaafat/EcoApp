<?php
    namespace App\Pipelines\Admin\VendorUser;

    use Closure;

    class FilterEmail
    {
        public function handle($request, Closure $next)
        {
            $data = $next($request);

            if (request()->has('email') && request('email') != '')
            {
                return  $data->Where('email','like', '%' . request('email') . '%');
            }
            return $data;
        }
    }