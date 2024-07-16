<?php
    namespace App\Pipelines\Admin\Customer;

    use Closure;

    class FilterPhone
    {
        public function handle($request, Closure $next)
        {
            $data = $next($request);

            if (request()->has('phone') && request('phone') != '')
            {
                return  $data->Where('phone','like', '%' . request('phone') . '%');
            }
            return $data;
        }
    }