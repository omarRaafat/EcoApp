<?php
    namespace App\Pipelines\Admin\Vendor;

    use Closure;

    class OrderCommission
    {
        public function handle($request, Closure $next)
        {
            $data = $next($request);
            $commission = request('commission_sort');
            if (request()->has('commission_sort') && $commission != '' && in_array($commission,['desc','asc']))
            {
                return  $data->orderBy('commission',$commission);
            }
            return $data;
        }
    }