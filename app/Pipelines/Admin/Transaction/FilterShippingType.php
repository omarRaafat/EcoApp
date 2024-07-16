<?php
namespace App\Pipelines\Admin\Transaction;

use Closure;

class FilterShippingType
{
    public function handle($request, Closure $next)
    {
        $data = $next($request);
        $search = request('shipping_type');
        if (request()->has('shipping_type') && request('shipping_type') != '')
        {
            $data->whereHas('orders.orderVendorShippings', function($q) use($search){
                $q->where('shipping_type_id' , $search);

            });
        }

        return $data;
    }
}
