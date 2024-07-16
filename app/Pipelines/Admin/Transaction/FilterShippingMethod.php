<?php
namespace App\Pipelines\Admin\Transaction;

use Closure;

class FilterShippingMethod
{
    public function handle($request, Closure $next)
    {
        $data = $next($request);
        $search = request('shipping_method');
        if (request()->has('shipping_method') && request('shipping_method') != '')
        {
            $data->whereHas('orders.orderVendorShippings', function($q) use($search){
                $q->where('shipping_method_id' , $search);

            });
        }
        return $data;
    }
}
