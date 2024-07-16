<?php
    namespace App\Pipelines\Admin\VendorUser;

    use Closure;

    class FilterVendor
    {
        public function handle($request, Closure $next)
        {
            $data = $next($request);

            if (request()->has('vendor_id') && request('vendor_id') != '')
            {
                return  $data->Where('vendor_id',request('vendor_id'));
            }
            return $data;
        }
    }